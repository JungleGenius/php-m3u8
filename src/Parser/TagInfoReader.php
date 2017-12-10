<?php

namespace Chrisyue\PhpM3u8\Parser;

use Doctrine\Common\Annotations\AnnotationReader;
use Chrisyue\PhpM3u8\Model\TagMetadata\TagMetadata;

class TagMetadataBag
{
    private $annotationReader;
    private $tagMetadatas = [];

    public function __construct(
        AnnotationReader $reader,
        PlaylistComponentFactory $factory
    ) {
        $this->annoationReader = $reader;

        $this->initTagMetadatas($factory->getMediaSegmentClass());
        $this->initTagMetadatas($factory->getMediaPlaylistClass());
        $this->initTagMetadatas($factory->getMasterPlaylistClass());
    }

    public function get($tag)
    {
        if (isset($this->tagMetadatas[$tag])) {
            return $this->tagMetadatas[$tag];
        }
    }

    private function initTagMetadatas($class)
    {
        $refClass = new \ReflectionClass($class);
        foreach ($refClass->getProperties() as $property) {
            foreach ($this->annotationReader->getPropertyAnnotations($property) as $tagMetadata) {
                $tagMetadata->propertyName = $property->getName();
                $this->setBelongsTo($tagMetadata, $class);
                $this->ensureTagName($tagMetadata);
                $this->tagMetadatas[$tagMetadata->name] = $tagMetadata;
            }
        }
    }

    private function ensureTagName(TagMetadata $tagMetadata)
    {
        if (null !== $tagMetadata->name) {
            return;
        }

        $tagMetadata->name = sprintf('EXT-X-%s', s($tagMetadata->propertyName)->dasherize()->toUpperCase());
    }

    private function setBelongsTo($tagMetadata, $class)
    {
        if (is_subclass_of($class, MediaSegment::class)) {
            $tagMetadata->belongsTo = 'MediaSegment';

            return;
        }

        $belongsTo = 'MediaPlaylist';
        if (is_subclass_of($class, MasterPlaylist::class)) {
            $belongsTo = 'MasterPlaylist';
        }

        if (null === $tagMetadata->belongsTo) {
            $tagMetadata->belongsTo = $belongsTo;

            return;
        }

        if ($belongsTo !== $tagMetadata->belongsTo) {
            $tagMetadata->belongsTo = 'Playlist';
        }
    }
}
