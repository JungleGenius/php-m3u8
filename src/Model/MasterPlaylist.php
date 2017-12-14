<?php

namespace Chrisyue\PhpM3u8\Model;

use Chrisyue\PhpM3u8\Model\Annotation\Tag;

class MasterPlaylist extends AbstractPlaylist
{
    /**
     * @Tag(type="Chrisyue\PhpM3u8\Model\Tag\SessionKey")
     */
    private $sessionKey;

    /**
     * @Tag(type="Chrisyue\PhpM3u8\Model\Tag\StreamInf", multiple=true)
     */
    private $streamInfs;

    public function __construct()
    {
        $this->streamInfs = new \ArrayObject();
    }
}
