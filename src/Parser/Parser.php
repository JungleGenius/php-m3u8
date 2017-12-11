<?php

namespace Chrisyue\PhpM3u8\Parser;

use Chrisyue\PhpM3u8\Model\MediaPlaylist;
use Chrisyue\PhpM3u8\Parser\PlaylistBuilder;
use Chrisyue\PhpM3u8\Parser\TagMetadataBag;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Chrisyue\PhpM3u8\Parser\Event\UriEvent;
use Chrisyue\PhpM3u8\Parser\Event\TagEvent;

class Parser
{
    private $builder;
    private $dispatcher;
    private $tagMetadataBag;

    public function __construct(
        PlaylistBuilder $builder,
        TagMetadataBag $tagMetadataBag,
        EventDispatcherInterface $dispatcher
    ) {
        $this->builder = $builder;
        $this->tagMetadataBag = $tagMetadataBag;
        $this->dispatcher = $dispatcher;

        $this->builder->initPlaylist();
    }

    public function parseLine($line)
    {
        $line = trim($line);
        if (empty($line)) {
            return;
        }

        if ('#' === $line[0]) {
            return $this->handleTag($line);
        }

        return $this->handleUri($line);
    }

    public function getPlaylist()
    {
        return $this->builder->getResult();
    }

    private function handleUri($uri)
    {
        $event = new UriEvent($uri);
        $this->dispatcher->dispatch('uri.parsed', $event);

        $this->builder->addUri($event->getUri());
    }

    private function handleTag($tag)
    {
        list($tag, $value) = array_pad(explode(':', substr($tag, 1)), 2, true);
        $info = $this->tagMetadataBag->get($tag);
        if (null === $info) {
            return;
        }

        if (\ArrayObject::class === $info->type) {
            $value = $this->parseAttributeListValue($value);
        }

        $event = new TagEvent($tag, $value);
        $this->dispatcher->dispatch('tag.parsed', $event);

        $builderMethod = sprintf('add%sTag', $info->category);
        $this->builder->$builderMethod($info->propertyName, $event->getValue(), $info->multiple);
    }

    private function parseAttributeListValue($value)
    {
        $attributes = $this->factory->createAttributeList();
        foreach (explode(',', $value) as $attr) {
            list($key, $value) = explode('=', $attr);
            $attributes[$key] = $value;
        }

        return $attributes;
    }
}
