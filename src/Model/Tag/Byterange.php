<?php

namespace Chrisyue\PhpM3u8\Model\Tag;

class Byterange implements FormattedTagInterface
{
    /**
     * @var string
     */
    private $length;

    /**
     * @var string
     */
    private $offset;

    static public function fromString($string)
    {
        $self = new self();
        sscanf($string, '%d@%d', $self->length, $self->offset);

        return $self;
    }

    /**
     * @param string $length
     *
     * @return self
     */
    public function setLength($length)
    {
        $this->length = $length;

        return $this;
    }

    /**
     * @return string
     */
    public function getLength()
    {
        return $this->length;
    }

    /**
     * @param string $offset
     *
     * @return self
     */
    public function setOffset($offset)
    {
        $this->offset = $offset;

        return $this;
    }

    /**
     * @return string
     */
    public function getOffset()
    {
        return $this->offset;
    }

    public function __toString()
    {
        if ($this->offset) {
            return sprintf('%d@%d', $this->length, $this->offset);
        }

        return $this->length;
    }
}
