<?php

namespace Chrisyue\PhpM3u8\Model;

use Chrisyue\PhpM3u8\Model\Annotation\Tag;
use Stringy\Stringy as S;
use Chrisyue\PhpM3u8\Model\Context;

abstract class AbstractPlaylist
{
    /**
     * @Tag
     */
    private $version;

    /**
     * @param int $version
     *
     * @return self
     */
    public function setVersion($version)
    {
        $this->version = $version;
        Context::$params['version'] = $version;

        return $this;
    }

    /**
     * @return int
     */
    public function getVersion()
    {
        return $this->version;
    }
}
