<?php

namespace Chrisyue\PhpM3u8\Parser;

use Chrisyue\PhpM3u8\Model\Mapping\TagMetadata;
use Chrisyue\PhpM3u8\Model\MasterPlaylist;
use Chrisyue\PhpM3u8\Model\MediaPlaylist;

class PlaylistBuilder
{
    private $factory;

    public function __construct(PlaylistComponentFactory $factory)
    {
        $this->factory = $factory;
    }

    public function initPlaylist()
    {
        $this->playlist = $this->factory->createPlaylistBuffer();
    }

    public function addPlaylistTag(TagMetadata $metadata, $value)
    {
        $this->ensurePlaylistType($metadata->getProperty()->getDeclaringClass()->getName());
        $this->callComponentSetter($this->playlist, $metadata, $value);
    }

    public function addMediaSegmentTag(TagMetadata $metadata, $value)
    {
        $this->ensurePlaylistType(MediaPlaylist::class);

        $segment = end($this->playlist->segments);
        if (!$segment || null !== $segment->uri) {
            $segment = $this->factory->createSegment();
            $this->playlist->segments->append($segment);
        }

        $this->callComponentSetter($segment, $metadata, $value);
    }

    public function addUri($uri)
    {
        if ($this->playlist instanceof PlaylistCopyableInterface) {
            throw new \RuntimeException('Adding URI to unknown playlist type');
        }

        $property = $this->playlist instanceof MasterPlaylist ? 'streamInfs' : 'segments';
        $component = end($this->playlist->$property);
        if (!$component || null !== $component->uri) {
            throw new \RuntimeException();
        }

        $component->uri = $uri;
    }

    public function getResult()
    {
        return $this->playlist;
    }

    private function callComponentSetter($component, TagMetadata $metadata, $value)
    {
        $property = $metadata->getProperty();
        $property->setAccessible(true);
        if ($metadata->isMultiple()) {
            return $property->getValue($component)->append($value);
        }

        $property->setValue($component, $value);
    }

    private function ensurePlaylistType($type)
    {
        if ($this->playlist instanceof $type) {
            return;
        }

        if (!$this->playlist instanceof PlaylistCopyableInterface) {
            throw new \RuntimeException('Different kinds of playlist tag in a same m3u8 content');
        }

        $playlist = $type === MediaPlaylist::class ? $this->factory->createMediaPlaylist() : $this->factory->createMasterPlaylist();
        $this->playlist->copyToPlaylist($playlist);
        $this->playlist = $playlist;
    }
}
