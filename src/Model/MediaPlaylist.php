<?php

namespace Chrisyue\PhpM3u8\Model;

use Chrisyue\PhpM3u8\Model\MediaSegment;

class MediaPlaylist extends AbstractPlaylist
{
    /**
     * @var int
     *
     * @Tag
     */
    private $targetDuration;

    /**
     * @var \ArrayObject
     */
    private $segments;

    public function __construct(\ArrayObject $segments)
    {
        $this->segments = $segments;
    }

    /**
     * @param int $targetDuration
     *
     * @return self
     */
    public function setTargetDuration($targetDuration)
    {
        $this->targetDuration = $targetDuration;

        return $this;
    }

    /**
     * @return int
     */
    public function getTargetDuration()
    {
        return $this->targetDuration;
    }

    /**
     * @return \ArrayObject
     */
    public function getSegments()
    {
        return $this->segments;
    }
}
