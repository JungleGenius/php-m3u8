<?php

namespace Chrisyue\PhpM3u8\Model\Tag;

class Inf
{
    /**
     * @var int|float
     */
    private $setDuration;

    /**
     * @var string
     */
    private $title;

    /**
     * @param int|float $setDuration
     *
     * @return self
     */
    public function setSetDuration($setDuration)
    {
        $this->setDuration = $setDuration;

        return $this;
    }

    /**
     * @return int|float
     */
    public function getSetDuration()
    {
        return $this->setDuration;
    }

    /**
     * @param string $title
     *
     * @return self
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }
}
