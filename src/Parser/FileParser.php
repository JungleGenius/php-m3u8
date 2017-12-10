<?php

namespace Chrisyue\PhpM3u8\Parser;

class FileParser
{
    private $parser;

    public function __construct()
    {
    }

    public function parse(\SplFileObject $file)
    {
        while (!$file->eof()) {
            $this->parser->parseLine($file->fgets());
        }

        return $this->parser->getPlaylist();
    }
}
