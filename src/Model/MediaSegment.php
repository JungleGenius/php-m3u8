<?php

namespace Chrisyue\PhpM3u8\Model;

use Chrisyue\PhpM3u8\Model\Annotation\Tag;

class MediaSegment
{
    use AutoGetterSetterTrait;

    /**
     * @Tag(type="Chrisyue\PhpM3u8\Model\Tag\Key", multiple=true)
     */
    private $keys;

    /**
     * @Tag(name="EXTINF", type="Chrisyue\PhpM3u8\Model\Tag\Inf")
     */
    private $inf;

    /**
     * @Tag
     */
    private $discontinuity = false;

    /**
     * @Tag(type="Chrisyue\PhpM3u8\Model\Tag\Byterange")
     */
    private $byterange;

    public $uri;

    public function __construct()
    {
        $this->keys = new \ArrayObject();
    }
}
