<?php

namespace Chrisyue\PhpM3u8\Model;

class MediaSegments extends \ArrayObject
{
    public function getDuration()
    {
        $duration = 0;
        foreach ($this as $segment) {
            $duration += $segment->getDuration();
        }

        return $duration;
    }
}
