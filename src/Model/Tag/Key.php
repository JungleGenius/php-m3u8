<?php

namespace Chrisyue\PhpM3u8\Model\Tag;

use Chrisyue\PhpM3u8\Model\Annotation\Attribute;
use Doctrine\Common\Annotations\Annotation\Enum;
use Doctrine\Common\Annotations\Annotation\Required;

class Key extends AbstractAttributeList
{
    /**
     * @Attribute
     * Required
     * Enum({"NONE", "AES-128", "SAMPLE-AES"})
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
