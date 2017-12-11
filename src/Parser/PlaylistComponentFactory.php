<?php

namespace Chrisyue\PhpM3u8\Parser;

use Chrisyue\PhpM3u8\Model\MediaSegment;
use Chrisyue\PhpM3u8\Model\MediaPlaylist;
use Chrisyue\PhpM3u8\Model\MasterPlaylist;
use Chrisyue\PhpM3u8\Parser\PlaylistBuffer;
use Chrisyue\PhpM3u8\Model\AttributeList;
use Chrisyue\PhpM3u8\Model\MediaSegments;

class PlaylistComponentFactory
{
    public function createSegment()
    {
        return new MediaSegment();
    }

    public function createMediaPlaylist()
    {
        return new MediaPlaylist($this->createSegments());
    }

    public function createMasterPlaylist()
    {
        return new MasterPlaylist();
    }

    public function createPlaylistBuffer()
    {
        return new PlaylistBuffer();
    }

    public function createAttributeList()
    {
        return new AttributeList();
    }

    protected function createSegments()
    {
        return new MediaSegments();
    }
}
