<?php

namespace Chrisyue\PhpM3u8\Model\Mapping;

abstract class AbstractMetadatas implements \IteratorAggregate
{
    protected $annotationReader;
    protected $metadatas = [];

    public function get($key)
    {
        if (isset($this->metadatas[$key])) {
            return $this->metadatas[$key];
        }
    }

    public function getByPropertyName($name)
    {
        foreach ($this->metadatas as $metadata) {
            if ($name === $metadata->getProperty()->getName()) {
                return $metadata;
            }
        }
    }

    public function getIterator()
    {
        return new \ArrayIterator($this->metadatas);
    }

    protected function load($class)
    {
        $refClass = new \ReflectionClass($class);

        foreach ($refClass->getProperties() as $refProp) {
            foreach ($this->annotationReader->getPropertyAnnotations($refProp) as $annot) {
                $this->generateMetadata($refProp, $annot);
            }
        }
    }

    abstract protected function generateMetadata(\ReflectionProperty $refProp, $annot);
}
