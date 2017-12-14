<?php

namespace Chrisyue\PhpM3u8\Model\Mapping;

use Chrisyue\PhpM3u8\Model\Util\StringUtil;

class AttributeMetadata extends AbstractPropertyMetadata
{
    public function __construct(\ReflectionProperty $property, $name = null, $type = null)
    {
        if (null === $name) {
            $name = (string) StringUtil::propertyToAttribute($property->getName());
        }
        parent::__construct($property, $name, $type);
    }
}
