<?php

namespace Chrisyue\PhpM3u8\Parser;

use Chrisyue\PhpM3u8\Model\MediaPlaylist;
use Chrisyue\PhpM3u8\Parser\PlaylistBuilder;
use Chrisyue\PhpM3u8\Parser\TagMetadataBag;

class Parser
{
    private $builder;
    private $tagMetadataBag;

    public function __construct(
        PlaylistBuilder $builder,
        TagMetadataBag $tagMetadataBag
    ) {
        $this->builder = $builder;
        $this->tagMetadataBag = $tagMetadataBag;

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

        $this->builder->addUri($line);
    }

    public function getPlaylist()
    {
        return $this->builder->getResult();
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

        $builderMethod = sprintf('add%sTag', $info->category);
        $this->builder->$builderMethod($info->propertyName, $value, $info->multiple);
    }

    private function parseAttributeListValue($value)
    {
        $attributes = [];
        foreach (explode(',', $value) as $attr) {
            list($key, $value) = explode('=', $attr);
            $attributes[$key] = $value;
        }

        return $attributes;
    }
}
