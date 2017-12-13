<?php

namespace Chrisyue\PhpM3u8\Dumper;

use Chrisyue\PhpM3u8\Model\AbstractPlaylist;
use Chrisyue\PhpM3u8\Model\MediaPlaylist;
use Chrisyue\PhpM3u8\Model\MasterPlaylist;
use Chrisyue\PhpM3u8\Parser\TagMetadataBag;
use Chrisyue\PhpM3u8\Model\Util\StringUtil;
use Chrisyue\PhpM3u8\Model\MediaSegment;

class Dumper
{
    private $tagMetadataBag;
    private $lines;

    public function __construct(TagMetadataBag $tagMetadataBag)
    {
        $this->tagMetadataBag = $tagMetadataBag;
    }

    public function dump(AbstractPlaylist $playlist)
    {
        $this->lines = ['#EXTM3U'];
        $this->generateComponentLines($playlist, new \ReflectionClass(AbstractPlaylist::class));
        $this->generateComponentLines($playlist, new \ReflectionClass($playlist instanceof MediaPlaylist ? MediaPlaylist::class : MasterPlaylist::class));

        return implode("\n", $this->lines);
    }

    private function getTagMetadata($property)
    {
        $tag = StringUtil::propertyToTag($property);

        return $this->tagMetadataBag->get($tag);
    }

    private function generateComponentLines($component, \ReflectionClass $refClass)
    {
        foreach ($refClass->getProperties() as $refProp) {
            $metadata = $this->getTagMetadata($refProp->getName());
            $refProp->setAccessible(true);
            if (!$metadata) {
                if ('segments' === $refProp->getName()) {
                    $mediaSegmentReflection = new \ReflectionClass(MediaSegment::class);
                    foreach ($refProp->getValue($component) as $segment) {
                        $this->generateComponentLines($segment, $mediaSegmentReflection);
                    }
                }

                continue;
            }

            $value = $refProp->getValue($component);
            if (!$value) {
                continue;
            }

            $line = $metadata->name;
            if (true !== $value) {
                $line = sprintf('%s:%s', $line, $value);
            }

            $this->lines[] = $line;
        }
    }
}
