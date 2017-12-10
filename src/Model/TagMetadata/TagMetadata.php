<?php

namespace Chrisyue\PhpM3u8\Model\TagMetadata;

/**
 * @Annotation
 * @Target("PROPERTY")
 */
class TagMetadata
{
    const TYPE_ATTRIBUTE_LIST = 'attribute-list';
    const TYPE_SIMPLE = 'simple';

    /**
     * @var string
     */
    public $name;

    /**
     * @var bool
     */
    public $multiple;

    /**
     * @ENUM({self::TYPE_ATTRIBUTE_LIST, self::TYPE_SIMPLE})
     */
    public $type;

    public $propertyName;
}
