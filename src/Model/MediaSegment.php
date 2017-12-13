<?php

namespace Chrisyue\PhpM3u8\Model;

use Chrisyue\PhpM3u8\Model\TagMetadata\TagMetadata as Tag;

class MediaSegment
{
    /**
     * @Tag(name="EXTINF", type="Chrisyue\PhpM3u8\Model\Tag\Inf")
     */
    public $inf;

    /**
     * @Tags(name="EXT-X-KEY", type="Chrisyue\PhpM3u8\Model\Tag\Key")
     */
    public $keys;

    /**
     * @Tag
     */
    public $discontinuity;

    public $uri;
}
