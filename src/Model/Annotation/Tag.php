<?php

namespace Chrisyue\PhpM3u8\Model\Annotation;

/**
 * @Annotation
 * @Target("PROPERTY")
 */
class Tag
{
    /**
     * @var string
     */
    public $name;

    /**
     * @var string
     */
    public $type;
}
