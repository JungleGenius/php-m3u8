<?php

namespace Chrisyue\PhpM3u8\Model;

class MediaSegment
{
    /**
     * @var mixed
     *
     * @Tag(name="EXTINF")
     */
    private $inf;

    /**
     * @var mixed
     * 
     * @Tag(type="attribute-list", multiple=true)
     */
    private $keys;

    /**
     * @var bool
     *
     * @Tag
     */
    private $discontinuity;

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
     * @param mixed $key
     *
     * @return self
     */
    public function addKey($key)
    {
        $this->keys->append($key);

        return $this;
    }

    /**
     * @return \ArrayObject
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
}
