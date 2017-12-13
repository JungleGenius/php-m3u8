<?php

namespace Chrisyue\PhpM3u8\Model;

use Chrisyue\PhpM3u8\Model\MediaSegment;
use Chrisyue\PhpM3u8\Model\TagMetadata\TagMetadata as Tag;

class MediaPlaylist extends AbstractPlaylist
{
    /**
     * @Tag
     */
    public $targetDuration;

    public $segments;
}
