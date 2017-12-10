<?php

namespace Chrisyue\PhpM3u8\Parser;

use Chrisyue\PhpM3u8\Model\MediaSegment;
use Chrisyue\PhpM3u8\Model\MediaPlaylist;
use Chrisyue\PhpM3u8\Model\MasterPlaylist;
use Chrisyue\PhpM3u8\Parser\PlaylistBuffer;

class PlaylistComponentFactory
{
    final public function createSegment()
    {
        $class = $this->getMediaSegmentClass();

        return new $class;
    }

    final public function createMediaPlaylist()
    {
        $class = $this->getMediaPlaylistClass();

        return new $class($this->createSegments());
    }

    final public function createMasterPlaylist()
    {
        $class = $this->getMasterPlaylistClass();

        return new $class();
    }

    public function createPlaylistBuffer()
    {
        return new PlaylistBuffer();
    }

    public function getMediaSegmentClass()
    {
        return MediaSegment::class;
    }

    public function getMediaPlaylistClass()
    {
        return MediaPlaylist::class;
    }

    public function getMasterPlaylistClass()
    {
        return MasterPlaylist::class;
    }

    protected function createSegments()
    {
        return new \ArrayObject();
    }
}
