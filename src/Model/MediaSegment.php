<?php

namespace Chrisyue\PhpM3u8\Model;

use Chrisyue\PhpM3u8\Model\TagMetadata\TagMetadata as Tag;

class MediaSegment
{
    /**
     * @var mixed
     *
     * @Tag(name="EXTINF")
     */
    private $inf;

    /**
     * @var ArrayObject
     *
     * @Tag(multiple=true)
     */
    private $keys;

    /**
     * @var bool
     *
     * @Tag
     */
    private $discontinuity;

    /**
     * @var string
     */
    private $uri;

    public function __construct()
    {
        $this->keys = new \ArrayObject();
    }

    /**
     * @param mixed $inf
     *
     * @return self
     */
    public function setInf($inf)
    {
        $this->inf = $inf;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getInf()
    {
        return $this->inf;
    }

    /**
     * @param ArrayObject $key
     *
     * @return self
     */
    public function addKey(\ArrayObject $key)
    {
        $this->keys->append($key);

        return $this;
    }

    /**
     * @return ArrayObject
     */
    public function getKeys()
    {
        return $this->keys;
    }

    /**
     * @param bool $discontinuity
     *
     * @return self
     */
    public function setDiscontinuity($discontinuity)
    {
        $this->discontinuity = $discontinuity;

        return $this;
    }

    /**
     * @return bool
     */
    public function isDiscontinuity()
    {
        return $this->discontinuity;
    }

    /**
     * @param string $uri
     *
     * @return self
     */
    public function setUri($uri)
    {
        $this->uri = $uri;

        return $this;
    }

    /**
     * @return string
     */
    public function getUri()
    {
        return $this->uri;
    }
}
