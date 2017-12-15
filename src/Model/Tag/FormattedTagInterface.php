<?php

namespace Chrisyue\PhpM3u8\Model\Tag;

interface FormattedTagInterface
{
    static public function fromString($string);

    public function __toString();
}
