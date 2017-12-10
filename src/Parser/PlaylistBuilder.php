<?php

namespace Chrisyue\PhpM3u8\Parser;

use Chrisyue\PhpM3u8\Model\MediaPlaylist;
use Chrisyue\PhpM3u8\Model\MasterPlaylist;
use Chrisyue\PhpM3u8\Parser\Event\UriEvent;
use Chrisyue\PhpM3u8\Parser\Event\TagEvent;

class PlaylistBuilder
{
    private $factory;

    public function __construct(PlaylistComponentFactory $factory)
    {
        $this->factory = $factory;
    }

    public function initPlaylist()
    {
        $this->playlist = $this->factory->createPlaylistBuffer();
    }

    public function addMasterPlaylistTag($propertyName, $value, $isMultiple = false)
    {
        $this->ensurePlaylistType(MasterPlaylist::class);
        $this->addPlaylistTag($propertyName, $value, $isMultiple);
    }

    public function addMediaPlaylistTag($propertyName, $value, $isMultiple = false)
    {
        $this->ensurePlaylistType(MediaPlaylist::class);
        $this->addPlaylistTag($propertyName, $value, $isMultiple);
    }

    public function addPlaylistTag($propertyName, $value, $isMultiple = false)
    {
        $this->addTagToComponent($this->playlist, $propertyName, $value, $isMultiple);
    }

    public function addMediaSegmentTag($propertyName, $value, $isMultiple = false)
    {
        $this->ensurePlaylistType(MediaPlaylist::class);

        $segment = end($this->playlist->getSegments());
        if (!$segment || null !== $segment->getUri()) {
            $segment = $this->factory->createSegment();
        }

        $this->addTagToComponent($segment, $propertyName, $value, $isMultiple);
        $this->playlist->getSegments()->append($segment);
    }

    public function addUri($uri)
    {
        if ($this->playlist instanceof PlaylistCopyableInterface::class) {
            throw new \RuntimeException('Adding URI to unknown playlist type');
        }

        if ($this->playlist instanceof MediaPlaylist::class) {
            $segment = end($this->playlist->getSegments());
            if (!$segment || null !== $segment->getUri()) {
                throw new \RuntimeException('EXTINF must be before URI');
            }

            $segment->setUri($uri);

            return;
        }

        $streamInf = end($this->playlist->getStreamInfs());
        if (!$streamInf || null !== $streamInf->getUri()) {
            throw new \RuntimeException('EXT-X-STREAM-INF must be before URI');
        }

        $streamInf->setUri($uri);
    }

    public function addStreamInfUri($uri)
    {
        $this->ensurePlaylistType(MasterPlaylist::class);

    }

    public function getResult()
    {
        return $this->playlist;
    }

    private function addTagToComponent($component, $propertyName, $value, $isMultiple)
    {
        $method = $isMultiple ? sprintf('add%s', substr($propertyName, 0, -1)) : sprintf('set%s', $propertyName);
        $this->playlist->$method($value);
    }

    private function ensurePlaylistType($type) {
        if ($this->playlist instanceof $type) {
            return;
        }

        if ($this->playlist instanceof PlaylistCopyableInterface) {
            $playlist = $type === MediaPlaylist::class ? $this->factory->createMediaPlaylist() : $this->factory->createMasterPlaylist();
            $this->playlist->copyToPlaylist($playlist);
            $this->playlist = $playlist;

            return;
        }

        throw new \RuntimeException();
    }
}
