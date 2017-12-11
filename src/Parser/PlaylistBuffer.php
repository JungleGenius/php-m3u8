<?php

namespace Chrisyue\PhpM3u8\Parser;

use Chrisyue\PhpM3u8\Model\AbstractPlaylist;

class PlaylistBuffer extends AbstractPlaylist implements PlaylistCopyableInterface
{
    public function copyToPlaylist(AbstractPlaylist $playlist)
    {
    }
}
