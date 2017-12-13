<?php

namespace Chrisyue\PhpM3u8\Model\Tag;

use Doctrine\Common\Annotations\Annotation\Required;
use Chrisyue\PhpM3u8\Model\Mapping\Attribute;
use Doctrine\Common\Annotations\Annotation\Enum;

class Key extends AbstractAttributeList
{
    /**
     * @Attribute
     * @Required
     * @Enum({"NONE", "AES-128", "SAMPLE-AES"})
     */
    public $method;

    /**
     * @Attribute
     */
    public $uri;

    /**
     * @Attribute
     */
    public $iv;

    /**
     * @Attribute
     */
    public $keyformat;

    /**
     * @Attribute
     */
    public $keyformatversions;
}
