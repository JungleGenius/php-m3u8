<?php

namespace Chrisyue\PhpM3u8\Parser;

use Chrisyue\PhpM3u8\Model\MediaPlaylist;
use Chrisyue\PhpM3u8\Model\MasterPlaylist;
use Chrisyue\PhpM3u8\Parser\Event\UriEvent;
use Chrisyue\PhpM3u8\Parser\Event\TagEvent;
use Chrisyue\PhpM3u8\Model\Util\StringUtil;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Chrisyue\PhpM3u8\Parser\Event\TagAddingEvent;
use Chrisyue\PhpM3u8\Parser\Event\UriAddingEvent;

class PlaylistBuilder
{
    private $factory;
    private $dispatcher;

    public function __construct(
        PlaylistComponentFactory $factory,
        EventDispatcherInterface $dispatcher
    ) {
        $this->factory = $factory;
        $this->dispatcher = $dispatcher;
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
        $this->callComponentSetter($this->playlist, $propertyName, $isMultiple, $value);
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

        $this->callComponentSetter($segment, $propertyName, $isMultiple, $value);
    }

    public function addUri($uri)
    {
        if ($this->playlist instanceof PlaylistCopyableInterface) {
            throw new \RuntimeException('Adding URI to unknown playlist type');
        }

        $method = $this->playlist instanceof MasterPlaylist ? 'getStreamInfs' : 'getSegments';
        $components = $this->playlist->$method();
        $component = end($components);
        if (!$component || null !== $component->getUri()) {
            throw new \RuntimeException();
        }

        $event = new UriAddingEvent($uri);
        $this->dispatcher->dispatch(UriAddingEvent::class, $event);

        $component->setUri($event->getUri());
    }

    public function getResult()
    {
        return $this->playlist;
    }

    private function callComponentSetter($component, $propertyName, $isMultiple, $value)
    {
        if (is_array($value)) {
            $value = $this->factory->createAttributeList($value);
        }

        $event = new TagAddingEvent($propertyName, $value);
        $this->dispatcher->dispatch(TagAddingEvent::class, $event);

        call_user_func([$component, StringUtil::propertyToSetter($propertyName, $isMultiple)], $event->getValue());
    }

    private function ensurePlaylistType($type) {
        if ($this->playlist instanceof $type) {
            return;
        }

        if (!$this->playlist instanceof PlaylistCopyableInterface) {
            throw new \RuntimeException('Different kinds of playlist tag in a same m3u8 content');
        }

        $playlist = $type === MediaPlaylist::class ? $this->factory->createMediaPlaylist() : $this->factory->createMasterPlaylist();
        $this->playlist->copyToPlaylist($playlist);
        $this->playlist = $playlist;
    }
}
