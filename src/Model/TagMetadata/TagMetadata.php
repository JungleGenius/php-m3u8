<?php

namespace Chrisyue\PhpM3u8\Model\TagMetadata;

/**
 * @Annotation
 * @Target("PROPERTY")
 */
class TagMetadata
{
    /**
     * @var string
     */
    public $name;

    /**
     * @var bool
     */
    public $multiple;

    /**
     * @var string
     */
    public $type;

    /**
     * @var string
     */
    public $propertyName;

    /**
     * @var string
     */
    public $category;

    /**
     * for doctrine annotation registry
     */
    static public function getFilePath()
    {
        return __FILE__;
    }
}
