<?php

namespace Chrisyue\PhpM3u8\Parser;

use Chrisyue\PhpM3u8\Model\Mapping\AttributeMetadatas;
use Chrisyue\PhpM3u8\Model\Mapping\TagMetadatas;
use Chrisyue\PhpM3u8\Model\MediaSegment;
use Chrisyue\PhpM3u8\Model\Tag\AbstractAttributeList;
use Chrisyue\PhpM3u8\Model\Mapping\TagMetadata;
use Chrisyue\PhpM3u8\Model\Tag\FormattedTagInterface;

class Parser
{
    private $builder;
    private $tagMetadatas;

    public function __construct(PlaylistBuilder $builder)
    {
        $this->builder = $builder;
        $this->tagMetadatas = new TagMetadatas();

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
        $tagMetadata = $this->tagMetadatas->get($tag);
        if (null === $tagMetadata) {
            return;
        }

        $class = $tagMetadata->getType();
        if (class_exists($class)) {
            switch (true) {
                case is_subclass_of($class, AbstractAttributeList::class):
                    $value = $this->createAttrTag($class, $value);
                    break;
                case is_subclass_of($class, FormattedTagInterface::class):
                    $value = $this->createFormattedTag($class, $value);
            }
        }

        switch ($tagMetadata->getProperty()->getDeclaringClass()->getName()) {
            case MediaSegment::class:
                $this->builder->addMediaSegmentTag($tagMetadata, $value);
                break;
            default:
                $this->builder->addPlaylistTag($tagMetadata, $value);
        }
    }

    private function createAttrTag($class, $value)
    {
        $attrMetadatas = new AttributeMetadatas($class);
        $attrTag = new $class();
        $this->parseAttributeListValue($value, function ($key, $val) use ($attrTag, $attrMetadatas) {
            if (!$attrMetadatas->get($key)) {
                return;
            }

            $metadata = $attrMetadatas->get($key);
            $metadata->getProperty()->setValue($attrTag, 'string' === $metadata->getType() ? trim($val, '"') : $val);
        });

        return $attrTag;
    }

    private function createFormattedTag($class, $value)
    {
        return $class::fromString($value);
    }

    private function parseAttributeListValue($value, callable $handler)
    {
        foreach (explode(',', $value) as $attr) {
            list($key, $value) = explode('=', $attr);

            $handler($key, $value);
        }
    }
}
