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

use Chrisyue\PhpM3u8\M3u8;
use Chrisyue\PhpM3u8\Segment;
use Chrisyue\PhpM3u8\Tag\KeyTag;

class DummyM3u8Factory
{
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
