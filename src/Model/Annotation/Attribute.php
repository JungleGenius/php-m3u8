<?php

namespace Chrisyue\PhpM3u8\Model\Annotation;

/**
 * @Annotation
 * @Target("PROPERTY")
 */
class Attribute
{
    /**
     * @var string
     */
    public $name;

    /**
     * @var string
     * @Enum({"string", "decimal", "hex", "float", "enum", "resolution"})
     */
    public $type;
}
