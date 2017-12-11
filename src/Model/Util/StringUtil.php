<?php

namespace Chrisyue\PhpM3u8\Model\Util;

use Stringy\Stringy as S;

class StringUtil
{
    static public function propertyToTag($property, $multiple = false)
    {
        if ($multiple) {
            $property = substr($property, 0, -1);
        }

        return sprintf('EXT-X-%s', S::create($property)->dasherize()->toUpperCase());
    }

    static public function propertyToSetter($property, $multiple = false)
    {
        return $multiple ? sprintf('add%s', substr($property, 0, -1)) : sprintf('set%s', $property);
    }

    static public function propertyToGetter($property)
    {
        return sprintf('get%s', ucfirst($property));
    }
}
