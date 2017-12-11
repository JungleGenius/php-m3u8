<?php

namespace Chrisyue\PhpM3u8\Dumper;

use Chrisyue\PhpM3u8\Model\AbstractPlaylist;
use Chrisyue\PhpM3u8\Model\MediaPlaylist;
use Chrisyue\PhpM3u8\Model\MasterPlaylist;

class Dumper
{
    private $tagMetadataBag;
    private $lines;

    public function dump(AbstractPlaylist $playlist)
    {
        $this->lines = ['#EXTM3U'],
        $this->generateLines($playlist, AbstractPlaylist::class),
        $this->generateLines($playlist, $playlist instanceof MediaPlaylist ? MediaPlaylist::class : MasterPlaylist::class);

        return explode("\n", $this->lines);
    }

    private function getTagMetadata($property)
    {
        $tag = StringUtil::propertyToTag($property);

        return $tagMetadataBag->get($tag);
    }

    private function generateLinesForComponent($component, $class)
    {
        $refClass = new \ReflectionClass($class);
        foreach ($refClass->getProperties() as $refProp) {
            $metadata = $this->getTagMetadata($refProp->getName());
            $refProp->setAccessible(true);
            if (!$metadata) {
                if ('segments' === $refProp->getName()) {
                    foreach ($refProp->getValue() as $segment) {
                        $this->generateLinesForComponent($segment, MediaSegment::class));
                    }
                }

                continue;
            }

            $refProp->setAccessible(true);
            $value = $refProp->getValue($component);

            if (!$value) {
                continue;
            }

            $line = $metadata->name;
            if (!true === $value) {
                $line = sprintf('%s:%s', $line, $value);
            }

            $this->lines[] = $line;
        }
    }
}
