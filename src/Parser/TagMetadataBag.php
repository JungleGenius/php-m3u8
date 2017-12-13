<?php

namespace Chrisyue\PhpM3u8\Parser;

use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\Annotations\AnnotationRegistry;
use Chrisyue\PhpM3u8\Model\TagMetadata\TagMetadata;
use Stringy\Stringy as S;
use Chrisyue\PhpM3u8\Model\MediaSegment;
use Chrisyue\PhpM3u8\Model\MasterPlaylist;
use Chrisyue\PhpM3u8\Model\AbstractPlaylist;
use Chrisyue\PhpM3u8\Model\MediaPlaylist;
use Chrisyue\PhpM3u8\Model\Util\StringUtil;

class TagMetadataBag
{
    private $annotationReader;
    private $tagMetadatas = [];

    public function __construct()
    {
        AnnotationRegistry::registerFile(TagMetadata::getFilePath());
        $this->annotationReader = new AnnotationReader();

        $this->initTagMetadatas(AbstractPlaylist::class);
        $this->initTagMetadatas(MediaPlaylist::class);
        $this->initTagMetadatas(MasterPlaylist::class);
        $this->initTagMetadatas(MediaSegment::class);
    }

    public function get($tag)
    {
        if (isset($this->tagMetadatas[$tag])) {
            return $this->tagMetadatas[$tag];
        }
    }

    private function initTagMetadatas($class)
    {
        $refClass = new \ReflectionClass($class);
        $category = str_replace('Abstract', '', $refClass->getShortName());

        foreach ($refClass->getProperties() as $property) {
            foreach ($this->annotationReader->getPropertyAnnotations($property) as $tagMetadata) {
                $tagMetadata->propertyName = $property->getName();
                $tagMetadata->category = $category;
                if (null === $tagMetadata->name) {
                    $tagMetadata->name = StringUtil::propertyToTag($property->getName(), $tagMetadata->multiple);
                }

                $methodName = StringUtil::propertyToSetter($property->getName(), $tagMetadata->multiple);
                $paramClassRef = $refClass->getMethod($methodName)->getParameters()[0]->getClass();

                $tagMetadata->type = 'mixed';
                if (null !== $paramClassRef) {
                    $tagMetadata->type = $paramClassRef->getName();
                }

                $this->tagMetadatas[$tagMetadata->name] = $tagMetadata;
            }
        }
    }
}
