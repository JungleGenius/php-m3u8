<?php

namespace Chrisyue\PhpM3u8\Parser;

use Chrisyue\PhpM3u8\Model\MediaPlaylist;
use Chrisyue\PhpM3u8\Parser\PlaylistBuilder;

class Parser
{
    private $builder;
    private $dispatcher;
    private $tagInfoReader;

    public function __construct(
        PlaylistBuilder $builder,
        TagInfoReader $tagInfoReader,
        EventDispatcherInterface $dispatcher
    ) {
        $this->builder = $builder;
        $this->tagInfoReader = $tagInfoReader;
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
            return $this->handleUri($line);
        }

        $this->handleTag($line);
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
        $info = $this->tagInfoReader->read($tag);

        if ('attributeList' === $info->type) {
            $value = $this->parseAttributelistValue($value);
        }

        $event = new TagEvent($tag, $value);
        $this->dispatcher->dispatch('tag.parsed', $event);

        $builderMethod = sprintf('add%sTag', $info->belongsTo);
        $this->builder->$builderMethod($info->propertyName, $event->getValue(), $info->multiple);
    }

    private function parseAttributeListValue($value)
    {
        $attributes = [];
        foreach (explode(',', $value) as $attr) {
            list($key, $value) = explode('=', $attr);
            $attributes[$key] = trim($value, '"');
        }

        return $attributes;
    }
}
