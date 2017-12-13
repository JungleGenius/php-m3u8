<?php

namespace Chrisyue\PhpM3u8\Model;

use Chrisyue\PhpM3u8\Model\TagMetadata\TagMetadata as Tag;

abstract class AbstractPlaylist
{
    /**
     * @Tag
     */
    public $version;
}
