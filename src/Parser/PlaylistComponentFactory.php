<?php

namespace Chrisyue\PhpM3u8\Parser;

use Chrisyue\PhpM3u8\Model\MasterPlaylist;
use Chrisyue\PhpM3u8\Model\MediaPlaylist;
use Chrisyue\PhpM3u8\Model\MediaSegment;

class PlaylistComponentFactory
{
    public function createSegment()
    {
        return new MediaSegment();
    }

    public function createMediaPlaylist()
    {
        return new MediaPlaylist();
    }

    public function createMasterPlaylist()
    {
        return new MasterPlaylist();
    }

    public function createPlaylistBuffer()
    {
        return new PlaylistBuffer();
    }
}
