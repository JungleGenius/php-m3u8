<?php

namespace Chrisyue\PhpM3u8\Dumper;

use Chrisyue\PhpM3u8\Model\AbstractPlaylist;
use Chrisyue\PhpM3u8\Model\MediaPlaylist;

class Dumper
{
    private $tagMetadataBag;
    private $lines;

    public function dump(AbstractPlaylist $playlist)
    {
        $this->lines = null;

        $this->generateCommonTagLines($playlist);
        if ($playlist instanceof MediaPlaylist) {
            $this->generateMediaPlaylistLines($playlist);

            return implode("\n", $this->lines);
        }

        $this->generateMasterPlaylistLines($playlist);

        return implode("\n", $this->lines);
    }

    private function generateCommonTagLines(AbstractPlaylist $playlist)
    {
        $this->lines = ['#EXTM3U'];
        $refClass = new \ReflectionClass(AbstractPlaylist::class);
        foreach ($refClass->getProperties() as $property) {
            $metadata = $this->getMetadataFromProperty($property);
            if (null === $metadata) {
                continue;
            }

            $this->generateLineByMetadata($playlist, $metadata);
        }
    }

    private function generateMediaPlaylistLines(MediaPlaylist $playlist)
    {
        $refClass = new \ReflectionClass($playlist);
        foreach ($refClass->getProperties() as $property) {
            $metadata = $this->getMetadataFromProperty($property);
            if (null === $metadata) {
                if ('segments' !== $property->getName()) {
                    continue;
                }

                $this->generateMediaSegmentLines($playlist->getSegments());

                continue;
            }

            $this->generateLineByMetadata($playlist, $metadata);
        }
    }

    private function generateMasterPlaylistLines(MasterPlaylist $playlist)
    {
        $refClass = new \ReflectionClass($playlist);
        foreach ($refClass->getProperties() as $property) {
            $metadata = $this->getMetadataFromProperty($property);
            if (null === $metadata) {
                continue;
            }

            $this->generateLineByMetadata($playlist, $metadata);
        }
    }

    private function generateMediaSegmentLines(\ArrayObject $segments)
    {
        if (0 === count($segments)) {
            return;
        }

        $refClass = new \ReflectionClass($segments[0]);
        foreach ($segments as $segment) {
            foreach ($refClass->getProperties() as $property) {
                $metadata = $this->getMetadataFromProperty($property);
                if (null === $metadata) {
                    continue;
                }

                $this->generateLineByMetadata($segment, $metadata);
            }
        }
    }

    private function getMetadataFromProperty(\ReflectionProperty $property)
    {
        $tag = StringUtil::propertyToTag($property->getName());

        return $tagMetadataBag->get($tag);
    }

    private function generateLineByMetadata($component, TagMetadata $metadata)
    {
        $value = call_user_func([$component, StringUtil::propertyToGetter($metadata->propertyName)]);
        if (\ArrayObject::class === $metadata->type) {
            $value = $this->dumpAttributeList($value);
        }

        if (is_bool($value)) {
            $this->lines[] = $tag;

            return;
        }

        $this->lines[] = sprintf('%s:%s', $tag, $value);
    }

    private function dumpAttributeList(\ArrayObject $attributes)
    {
        $attrs = [];
        foreach ($attributes as $key => $value) {
            if (null === $value) {
                continue;
            }
            $attrs[] = sprintf('%s=%s', $key, $value);
        }

        return implode(',', $attrs);
    }
}
