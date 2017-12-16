<?php

namespace Chrisyue\PhpM3u8\Model\Tag;

use Chrisyue\PhpM3u8\Model\Annotation\Attribute;

class SessionData extends AbstractAttributeList
{
    /**
     * @Attribute(type="string")
     */
    public $dataId;

    /**
     * @Attribute(type="string")
     */
    public $values;

    /**
     * @Attribute(type="string")
     */
    public $uri;

    /**
     * @Attribute(type="string")
     */
    public $language;
}
