<?php

namespace Chrisyue\PhpM3u8\Model;

use Chrisyue\PhpM3u8\Model\TagMetadata\TagMetadata as Tag;

class MasterPlaylist extends AbstractPlaylist
{
    /**
     * @var mixed
     *
     * @Tag
     */
    private $sessionKey;

    /**
     * @var ArrayObject
     *
     * @Tag(multiple=true)
     */
    private $streamInfs;

    public function __construct()
    {
        $this->streamInfs = new \ArrayObject();
    }

    /**
     * @param mixed $sessionKey
     *
     * @return self
     */
    public function setSessionKey($sessionKey)
    {
        $this->sessionKey = $sessionKey;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getSessionKey()
    {
        return $this->sessionKey;
    }

    /**
     * @param ArrayObject $streamInf
     *
     * @return self
     */
    public function addStreamInf(\ArrayObject $streamInf)
    {
        $this->streamInfs->append($streamInf);

        return $this;
    }

    /**
     * @return ArrayObject
     */
    public function getStreamInfs()
    {
        return $this->streamInfs;
    }
}
