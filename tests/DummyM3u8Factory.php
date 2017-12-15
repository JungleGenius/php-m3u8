<?php

/*
 * This file is part of the PhpM3u8 package.
 *
 * (c) Chrisyue <http://chrisyue.com/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Chrisyue\PhpM3u8\tests;

use Chrisyue\PhpM3u8\Model\MediaPlaylist;
use Chrisyue\PhpM3u8\Model\MediaSegment;
use Chrisyue\PhpM3u8\Model\Tag;

class DummyM3u8Factory
{
    public static function createM3u8($version = 3)
    {
        $playlist = new MediaPlaylist();
        $playlist->setVersion($version)
            ->setMediaSequence(33)
            ->setDiscontinuitySequence(3)
            ->setTargetduration(12)
            ->setEndless(true);

        $segment = new MediaSegment($version);

        $key = new Tag\Key();
        $key->setMethod('AES-128')->setUri('key')->setIv('0xF85A5066CCB442181ACACA2E862A34DC');
        $segment->getKeys()->append($key);

        $key = new Tag\Key();
        $key->setMethod('SAMPLE-AES')->setUri('key2')->setIv('0xF85A5066CCB442181ACACA2E862A34DC')
            ->setKeyformat('com.apple')->setKeyformatversions("1");
        $segment->getKeys()->append($key);

        $inf = new Tag\Inf();
        $inf->setDuration(12.000)->setTitle('hello world');
        $segment->setInf($inf);

        $byterange = new Tag\Byterange();
        $byterange->setLength(10000)->setOffset(100);
        $segment->setByterange($byterange);

        $segment->setUri('stream33.ts');

        $playlist->getSegments()->append($segment);

        $segment = new MediaSegment();
        $inf = new Tag\Inf();
        $inf->setDuration(10.000);
        $segment->setInf($inf)
            ->setDiscontinuity(true);
        $segment->setUri('video01.ts');

        $playlist->getSegments()->append($segment);

        return $playlist;
    }

    public static function createM3u8Content($version = 3)
    {
        if ($version < 3) {
            return <<<'M3U8'
#EXTM3U
#EXT-X-VERSION:2
#EXT-X-TARGETDURATION:12
#EXT-X-MEDIA-SEQUENCE:33
#EXT-X-DISCONTINUITY-SEQUENCE:3
#EXT-X-KEY:METHOD=AES-128,URI="key",IV=0xF85A5066CCB442181ACACA2E862A34DC
#EXT-X-KEY:METHOD=SAMPLE-AES,URI="key2",IV=0xF85A5066CCB442181ACACA2E862A34DC,KEYFORMAT="com.apple",KEYFORMATVERSIONS="1"
#EXTINF:12,hello world
#EXT-X-BYTERANGE:10000@100
stream33.ts
#EXTINF:10,
#EXT-X-DISCONTINUITY
video01.ts
M3U8;
        }

        return <<<'M3U8'
#EXTM3U
#EXT-X-VERSION:3
#EXT-X-TARGETDURATION:12
#EXT-X-MEDIA-SEQUENCE:33
#EXT-X-DISCONTINUITY-SEQUENCE:3
#EXT-X-KEY:METHOD=AES-128,URI="key",IV=0xF85A5066CCB442181ACACA2E862A34DC
#EXT-X-KEY:METHOD=SAMPLE-AES,URI="key2",IV=0xF85A5066CCB442181ACACA2E862A34DC,KEYFORMAT="com.apple",KEYFORMATVERSIONS="1"
#EXTINF:12.000,hello world
#EXT-X-BYTERANGE:10000@100
stream33.ts
#EXTINF:10.000,
#EXT-X-DISCONTINUITY
video01.ts
M3U8;
    }
}

