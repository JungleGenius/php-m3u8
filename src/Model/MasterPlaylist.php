<?php

namespace Chrisyue\PhpM3u8\Model;

use Chrisyue\PhpM3u8\Model\TagMetadata\TagMetadata as Tag;

class MasterPlaylist extends AbstractPlaylist
{
    /**
     * @Tag(type="Chrisyue\PhpM3u8\Model\Tag\SessionKey")
     */
    public $sessionKey;

    /**
     * @Tags(name="EXT-X-STREAMINF", type="Chrisyue\PhpM3u8\Model\Tag\StreamInf")
     */
    public $streamInfs;
}
