<?php

namespace Chrisyue\PhpM3u8\Model;

use Chrisyue\PhpM3u8\Model\Annotation\Tag;

class MediaPlaylist extends AbstractPlaylist
{
    use AutoGetterSetterTrait;

    /**
     * @Tag
     */
    private $targetduration;

    /**
     * @Tag
     */
    private $mediaSequence;

    /**
     * @Tag
     */
    private $discontinuitySequence;

    public $segments;

    /**
     * @Tag
     */
    private $endlist;

    public function __construct()
    {
        $this->segments = new \ArrayObject();
    }

    public function getDuration()
    {
        $duration = 0;
        foreach ($this->segments as $segment) {
            $duration += $segment->getInf()->getDuration();
        }

        return $duration;
    }
}
