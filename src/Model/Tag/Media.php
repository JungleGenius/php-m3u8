<?php

namespace Chrisyue\PhpM3u8\Model\Tag;

use Chrisyue\PhpM3u8\Model\Annotation\Attribute;

class Media extends AbstractAttributeList
{
    /**
     * @Attribute(type="enum")
     */
    public $type;

    /**
     * @Attribute(type="string")
     */
    public $uri;

    /**
     * @Attribute(type="string")
     */
    public $groupId;

    /**
     * @Attribute(type="string")
     */
    public $language;

    /**
     * @Attribute(type="string")
     */
    public $assocLanguage;

    /**
     * @Attribute(type="string")
     */
    public $name;

    /**
     * @Attribute(type="enum")
     */
    public $default;

    /**
     * @Attribute(type="enum")
     */
    public $autoselect;

    /**
     * @Attribute(type="enum")
     */
    public $forced;

    /**
     * @Attribute(type="string")
     */
    public $instreamId;

    /**
     * @Attribute(type="string")
     */
    public $characteristics;

    /**
     * @Attribute(type="string")
     */
    public $channels;
}
