<?php

namespace Chrisyue\PhpM3u8\Model;

use Stringy\Stringy as S;

trait AutoGetterSetterTrait
{
    public function __call($method, array $arguments)
    {
        $string = S::create($method);
        if (!$string->startsWithAny(['has', 'get', 'is', 'set'])) {
            throw new \BadMethodCallException($method);
        }

        $property = lcfirst(preg_replace('/^(has|get|is|set)/', '', $method));
        if ($string->startsWithAny(['set'])) {
            $this->$property = current($arguments);

            return $this;
        }

        if (property_exists($this, $property)) {
            return $this->$property;
        }

        throw new \BadMethodCallException();
    }
}
