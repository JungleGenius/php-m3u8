<?php

namespace Chrisyue\PhpM3u8\Parser;

use Chrisyue\PhpM3u8\Model\AbstractPlaylist;

interface PlaylistCopyableInterface
{
    public function copyToPlaylist(AbstractPlaylist $playlist);
}
