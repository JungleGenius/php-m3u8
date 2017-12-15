<?php

namespace Chrisyue\PhpM3u8\Model\Tag;

use Chrisyue\PhpM3u8\Model\Context;

class Inf implements FormattedTagInterface
{
    /**
     * @var int|float
     */
    private $duration;

    /**
     * @var string
     */
    private $title;

    static public function fromString($string)
    {
        $self = new self();
        list($self->duration, $self->title) = explode(',', $string);

        return $self;
    }

    /**
     * @param int|float $duration
     *
     * @return self
     */
    public function setDuration($duration)
    {
        $this->duration = $duration;

        return $this;
    }

    /**
     * @return int|float
     */
    public function getDuration()
    {
        return $this->duration;
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

    /**
     * @return string
     */
    public function __toString()
    {
        if (Context::$params['version'] > 2) {
            return sprintf('%.3f,%s', $this->duration, $this->title);
        }

        return sprintf('%d,%s', $this->duration, $this->title);
    }
}
