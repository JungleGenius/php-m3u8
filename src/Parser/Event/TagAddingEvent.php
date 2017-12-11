<?php

namespace Chrisyue\PhpM3u8\Parser\Event;

use Symfony\Component\EventDispatcher\Event;

class TagAddingEvent extends Event
{
    /**
     * @var string
     */
    private $property;

    /**
     * @var mixed
     */
    private $value;

    public function __construct($property, $value)
    {
        $this->property = $property;
        $this->value = $value;
    }

    /**
     * @return string
     */
    public function getProperty()
    {
        return $this->property;
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
