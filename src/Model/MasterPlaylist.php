<?php

namespace Chrisyue\PhpM3u8\Model;

use Chrisyue\PhpM3u8\Model\Annotation\Tag;

class MasterPlaylist extends AbstractPlaylist
{
    use AutoGetterSetterTrait;

    /**
     * @Tag(type="Chrisyue\PhpM3u8\Model\Tag\StreamInf", multiple=true)
     */
    private $streamInfs;

    /**
     * @Tag(type="Chrisyue\PhpM3u8\Model\Tag\Media", multiple=true)
     */
    private $medias;

    /**
     * @Tag(type="Chrisyue\PhpM3u8\Model\Tag\IFrameStreamInf")
     */
    private $iFrameStreamInf;

    /**
     * @Tag(type="Chrisyue\PhpM3u8\Model\Tag\SessionData")
     */
    private $sessionData;

    /**
     * @Tag(type="Chrisyue\PhpM3u8\Model\Tag\SessionKey")
     */
    private $sessionKey;

    public function __construct()
    {
        $this->streamInfs = new \ArrayObject();
        $this->medias = new \ArrayObject();
    }
}
