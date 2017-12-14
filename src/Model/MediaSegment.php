<?php

namespace Chrisyue\PhpM3u8\Model;

use Chrisyue\PhpM3u8\Model\Annotation\Tag;

class MediaSegment
{
    /**
     * @Tag(name="EXTINF", type="Chrisyue\PhpM3u8\Model\Tag\Inf")
     */
    private $inf;

    /**
     * @Tag(type="Chrisyue\PhpM3u8\Model\Tag\Key", multiple=true)
     */
    private $keys;

    /**
     * @Tag
     */
    private $discontinuity;

    /**
     * @Tag
     */
    private $byterange;

    public $uri;

    public function __construct()
    {
        $this->keys = new \ArrayObject();
    }
}
