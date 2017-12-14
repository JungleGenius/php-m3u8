<?php

namespace Chrisyue\PhpM3u8\Model\Mapping;

use Chrisyue\PhpM3u8\Model\AbstractPlaylist;
use Chrisyue\PhpM3u8\Model\Annotation\Tag;
use Chrisyue\PhpM3u8\Model\MasterPlaylist;
use Chrisyue\PhpM3u8\Model\MediaPlaylist;
use Chrisyue\PhpM3u8\Model\MediaSegment;
use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\Annotations\AnnotationRegistry;

class TagMetadatas extends AbstractMetadatas
{
    public function __construct()
    {
        AnnotationRegistry::registerFile((new \ReflectionClass(Tag::class))->getFileName());
        $this->annotationReader = new AnnotationReader();

        $this->load(AbstractPlaylist::class);
        $this->load(MediaPlaylist::class);
        $this->load(MasterPlaylist::class);
        $this->load(MediaSegment::class);
    }

    protected function generateMetadata(\ReflectionProperty $property, $annot)
    {
        $metadata = new TagMetadata($property, $annot->name, $annot->type, $annot->multiple);

        if (!isset($this->metadatas[$metadata->getName()])) {
            $this->metadatas[$metadata->getName()] = $metadata;
        }
    }
}
