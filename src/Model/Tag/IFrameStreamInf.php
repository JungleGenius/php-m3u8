<?php

namespace Chrisyue\PhpM3u8\Model\Tag;

use Chrisyue\PhpM3u8\Model\Annotation\Attribute;

class IFrameStreamInf extends AbstractSessionInf
{
    /**
     * @Attribute(type="string")
     */
    public $uri;
}
