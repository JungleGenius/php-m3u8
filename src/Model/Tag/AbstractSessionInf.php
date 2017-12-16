<?php

namespace Chrisyue\PhpM3u8\Model\Tag;

abstract class AbstractSessionInf extends AbstractAttributeList
{
    /**
     * @Attribute(type="int")
     */
    public $bandwidth;

    /**
     * @Attribute(type="int")
     */
    public $averageBandwidth;

    /**
     * @Attribute(type="string")
     */
    public $codecs;

    /**
     * @Attribute(type="resolution")
     */
    public $resolution;

    /**
     * @Attribute(type="enum")
     */
    public $hdcpLevel;

    /**
     * @Attribute(type="string")
     */
    public $video;
}
