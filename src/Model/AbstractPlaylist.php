<?php

namespace Chrisyue\PhpM3u8\Model;

use Chrisyue\PhpM3u8\Model\Annotation\Tag;

abstract class AbstractPlaylist
{
    /**
     * @var int
     *
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
