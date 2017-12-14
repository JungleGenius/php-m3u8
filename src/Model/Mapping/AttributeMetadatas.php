<?php

namespace Chrisyue\PhpM3u8\Model\Mapping;

use Chrisyue\PhpM3u8\Model\Annotation\Attribute;
use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\Annotations\AnnotationRegistry;

class AttributeMetadatas extends AbstractMetadatas
{
    public function __construct($class)
    {
        AnnotationRegistry::registerFile((new \ReflectionClass(Attribute::class))->getFileName());
        $this->annotationReader = new AnnotationReader();

        $this->load($class);
    }

    protected function generateMetadata(\ReflectionProperty $property, $annot)
    {
        $metadata = new AttributeMetadata($property, $annot->name, $annot->type);

        $this->metadatas[$metadata->getName()] = $metadata;
    }
}
