<?php

namespace Chrisyue\PhpM3u8\Model\Tag;

class StreamInf extends AbstractSessionInf
{
    /**
     * @Attribute(type="float")
     */
    public $frameRate;

    /**
     * @Attribute(type="string")
     */
    public $audio;

    /**
     * @Attribute(type="string")
     */
    public $subtitles;

    /**
     * could be NONE, should be fixed
     *
     * @Attribute(type="string")
     */
    public $closedCaptions;

    public $uri;
}
