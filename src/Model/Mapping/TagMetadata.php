<?php

namespace Chrisyue\PhpM3u8\Model\Mapping;

use Chrisyue\PhpM3u8\Model\Util\StringUtil;

class TagMetadata extends AbstractPropertyMetadata
{
    /**
     * @var bool
     */
    private $multiple;

    public function __construct(\ReflectionProperty $property, $name = null, $type = null, $multiple = false)
    {
        if (null === $name) {
            $name = StringUtil::propertyToTag($property->getName(), $multiple);
        }
        parent::__construct($property, $name, $type);

        $this->multiple = $multiple;
    }

    /**
     * @return bool
     */
    public function isMultiple()
    {
        return $this->multiple;
    }
}
