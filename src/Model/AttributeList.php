<?php

namespace Chrisyue\PhpM3u8\Model;

use Stringy\Stringy as S;

class AttributeList extends \ArrayObject
{
    public function __call($method, array $arguments)
    {
        if (0 !== strrpos($method, 'get', -strlen($method))) {
            throw new \BadMethodCallException();
        }

        $property = substr($method, 3);
        $key = S::create($property)->dasherize()->toUpperCase();

        return $this->offsetGet($key);
    }
}
