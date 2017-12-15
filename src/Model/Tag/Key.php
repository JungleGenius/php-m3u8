<?php

namespace Chrisyue\PhpM3u8\Model\Tag;

use Chrisyue\PhpM3u8\Model\Annotation\Attribute;

class Key extends AbstractAttributeList
{
    /**
     * @Attribute
     */
    public $method;

    /**
     * @Attribute(type="string")
     */
    public $uri;

    /**
     * @Attribute(type="hex")
     */
    public $iv;

    /**
     * @Attribute(type="string")
     */
    public $keyformat;

    /**
     * @Attribute(type="string")
     */
    public $keyformatversions;
}
