<?php

namespace Chrisyue\PhpM3u8\Model;

use Chrisyue\PhpM3u8\Model\Annotation\Tag;
use Stringy\Stringy as S;
use Chrisyue\PhpM3u8\Model\Context;
use Chrisyue\PhpM3u8\Model\Tag\Start;

abstract class AbstractPlaylist
{
    /**
     * @Tag
     */
    private $version;

    /**
     * @Tag
     */
    private $independentSegments;

    /**
     * @Tag(type="Chrisyue\PhpM3u8\Model\Tag\Start")
     */
    private $start;

    /**
     * @return bool
     */
    public function isIndependentSegments()
    {
        return $this->independentSegments;
    }

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

    /**
     * @param bool $independentSegments
     *
     * @return self
     */
    public function setIndependentSegments($independentSegments)
    {
        $this->independentSegments = $independentSegments;

        return $this;
    }

    /**
     * @param Start $start
     *
     * @return self
     */
    public function setStart(Start $start)
    {
        $this->start = $start;

        return $this;
    }

    /**
     * @return Start
     */
    public function getStart()
    {
        return $this->start;
    }
}
