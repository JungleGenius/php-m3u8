<?php

namespace Chrisyue\PhpM3u8\Parser\Event;

use Symfony\Component\EventDispatcher\Event;

class UriAddingEvent extends Event
{
    /**
     * @var string
     */
    private $uri;

    public function __construct($uri)
    {
        $this->uri = $uri;
    }

    /**
     * @param string $uri
     *
     * @return self
     */
    public function setUri($uri)
    {
        $this->uri = $uri;

        return $this;
    }

    /**
     * @return string
     */
    public function getUri()
    {
        return $this->uri;
    }
}
