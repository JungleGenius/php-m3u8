<?php

namespace Chrisyue\PhpM3u8\Parser;

interface PlaylistCopyableInterface
{
    public function copyToPlaylist(AbstractPlaylist $playlist);
}
