<?php

namespace Chrisyue\PhpM3u8\Model\Mapping;

abstract class AbstractPropertyMetadata
{
    /**
     * @var ReflectionProperty
     */
    private $property;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $type;

    public function __construct(\ReflectionProperty $property, $name, $type = null)
    {
        $this->property = $property;
        $this->name = $name;
        $this->type = $type;
    }

    /**
     * @return ReflectionProperty
     */
    public function getProperty()
    {
        return $this->property;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }
}
