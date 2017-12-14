<?php

namespace Chrisyue\PhpM3u8\Dumper;

use Chrisyue\PhpM3u8\Model\AbstractPlaylist;
use Chrisyue\PhpM3u8\Model\Mapping\AttributeMetadatas;
use Chrisyue\PhpM3u8\Model\Mapping\TagMetadata;
use Chrisyue\PhpM3u8\Model\Mapping\TagMetadatas;
use Chrisyue\PhpM3u8\Model\MasterPlaylist;
use Chrisyue\PhpM3u8\Model\MediaPlaylist;
use Chrisyue\PhpM3u8\Model\MediaSegment;
use Chrisyue\PhpM3u8\Model\Tag\AbstractAttributeList;

class Dumper
{
    private $tagMetadatas;
    private $lines;

    public function __construct()
    {
        $this->tagMetadatas = new TagMetadatas();
    }

    public function dump(AbstractPlaylist $playlist)
    {
        $this->lines = ['#EXTM3U'];
        $this->generateComponentLines($playlist, new \ReflectionClass(AbstractPlaylist::class));
        $this->generateComponentLines($playlist, new \ReflectionClass($playlist instanceof MediaPlaylist ? MediaPlaylist::class : MasterPlaylist::class));

        return implode("\n", $this->lines);
    }

    private function generateComponentLines($component, \ReflectionClass $refClass)
    {
        foreach ($refClass->getProperties() as $refProp) {
            $refProp->setAccessible(true);
            if ('segments' === $refProp->getName()) {
                $refMs = new \ReflectionClass(MediaSegment::class);
                foreach ($refProp->getValue($component) as $segment) {
                    $this->generateComponentLines($segment, $refMs);
                }

                continue;
            }

            if ('uri' === $refProp->getName()) {
                $this->lines[] = $component->uri;
            }

            $metadata = $this->tagMetadatas->getByPropertyName($refProp->getName());
            if (!$metadata) {
                continue;
            }

            $value = $refProp->getValue($component);
            if (!$value) {
                continue;
            }

            if ($metadata->isMultiple()) {
                foreach ($value as $val) {
                    $this->lines[] = $this->createLine($metadata, $val);
                }
                continue;
            }

            $this->lines[] = $this->createLine($metadata, $value);
        }
    }

    private function createLine(TagMetadata $metadata, $value)
    {
        $line = $metadata->getName();
        if (true === $value) {
            return $line;
        }

        if (!$value instanceof AbstractAttributeList) {
            return sprintf('%s:%s', $line, $value);
        }

        $attrMetadatas = new AttributeMetadatas($metadata->getType());
        $attrs = [];
        foreach ($attrMetadatas as $attrMetadata) {
            $name = $attrMetadata->getName();
            $val = $attrMetadata->getProperty()->getValue($value);
            if (null === $val) {
                continue;
            }

            if ('string' === $attrMetadata->getType()) {
                $val = sprintf('"%s"', $val);
            }
            $attrs[] = sprintf('%s=%s', $name, $val);
        }

        return implode(',', $attrs);
    }
}
