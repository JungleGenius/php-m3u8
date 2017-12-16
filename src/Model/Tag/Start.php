<?php

namespace Chrisyue\PhpM3u8\Model\Tag;

use Chrisyue\PhpM3u8\Model\Annotation\Attribute;

class Start extends AbstractAttributeList
{
    /**
     * @Attribute(type="float")
     */
    public $timeOffset;

    /**
     * @Attribute(type="enum")
     */
    public $precise;
}
