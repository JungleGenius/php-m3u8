<?php

namespace Chrisyue\PhpM3u8\Model;

class MasterPlaylist extends AbstractPlaylist
{
    /**
     * @var mixed
     *
     * @Tag(type="attribute-list")
     */
    private $sessionKey;

    /**
     * @var mixed
     *
     * @Tag(type="attribute-list", multiple=true)
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
     * @param mixed $streamInf
     *
     * @return self
     */
    public function addStreamInf($streamInf)
    {
        $this->streamInfs->append($streamInf);

        return $this;
    }

    /**
     * @return \ArrayObject
     */
    public function getStreamInfs()
    {
        return $this->streamInfs;
    }
}
