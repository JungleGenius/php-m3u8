<?php

namespace Chrisyue\PhpM3u8\Parser;

use Chrisyue\PhpM3u8\Model\MediaPlaylist;
use Chrisyue\PhpM3u8\Model\MasterPlaylist;
use Chrisyue\PhpM3u8\Parser\Event\UriEvent;
use Chrisyue\PhpM3u8\Parser\Event\TagEvent;
use Chrisyue\PhpM3u8\Model\Util\StringUtil;

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
        call_user_func([$this->playlist, StringUtil::propertyToSetter($propertyName, $isMultiple)], $value);
    }

    public function addMediaSegmentTag($propertyName, $value, $isMultiple = false)
    {
        $this->ensurePlaylistType(MediaPlaylist::class);
        $segments = $this->playlist->getSegments();
        $segment = end($segments);
        if (!$segment || null !== $segment->getUri()) {
            $segment = $this->factory->createSegment();
            $segments->append($segment);
        }

        call_user_func([$segment, StringUtil::propertyToSetter($propertyName, $isMultiple)], $value);
    }

    public function addUri($uri)
    {
        if ($this->playlist instanceof PlaylistCopyableInterface) {
            throw new \RuntimeException('Adding URI to unknown playlist type');
        }

        if ($this->playlist instanceof MediaPlaylist) {
            $segments = $this->playlist->getSegments();
            $segment = end($segments);
            if (!$segment || null !== $segment->getUri()) {
                throw new \RuntimeException('EXTINF must be before URI');
            }

            $segment->setUri($uri);

            return;
        }

        $streamInf = end($streamInfs = $this->playlist->getStreamInfs());
        if (!$streamInf || null !== $streamInf->getUri()) {
            throw new \RuntimeException('EXT-X-STREAM-INF must be before URI');
        }

        $streamInf->setUri($uri);
    }

    public function getResult()
    {
        return $this->playlist;
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

        throw new \RuntimeException('Different kinds of playlist tag in same m3u8 content');
    }
}
