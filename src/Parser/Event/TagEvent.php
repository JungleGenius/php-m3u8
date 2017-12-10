<?php

namespace Chrisyue\PhpM3u8\Parser\Event;

class TagEvent
{
    /**
     * @var string
     */
    private $tag;

    /**
     * @var mixed
     */
    private $value;

    public function __construct($tag, $value)
    {
        $this->tag = $tag;
        $this->value = $value;
    }

    /**
     * @return string
     */
    public function getTag()
    {
        return $this->tag;
    }

    /**
     * @param mixed $value
     *
     * @return self
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }
}
