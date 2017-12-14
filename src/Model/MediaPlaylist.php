<?php

namespace Chrisyue\PhpM3u8\Model;

use Chrisyue\PhpM3u8\Model\Annotation\Tag;

class MediaPlaylist extends AbstractPlaylist
{
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
}
