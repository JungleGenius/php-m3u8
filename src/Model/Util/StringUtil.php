<?php

namespace Chrisyue\PhpM3u8\Model\Util;

use Stringy\Stringy as S;

class StringUtil
{
    public static function propertyToTag($property, $multiple = false)
    {
        if ($multiple) {
            $property = substr($property, 0, -1);
        }

        return sprintf('EXT-X-%s', self::propertyToAttribute($property));
    }

    public static function propertyToAttribute($property)
    {
        return S::create($property)->dasherize()->toUpperCase();
    }
}
