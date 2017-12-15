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

use PHPUnit\Framework\TestCase;
use Chrisyue\PhpM3u8\Parser\Parser;
use Chrisyue\PhpM3u8\Parser\PlaylistBuilder;
use Chrisyue\PhpM3u8\Parser\PlaylistComponentFactory;
use Chrisyue\PhpM3u8\Dumper\Dumper;

class ParserTest extends TestCase
{
    public function testRead()
    {
        $content = DummyM3u8Factory::createM3u8Content(2);

        $parser = new Parser(new PlaylistBuilder(new PlaylistComponentFactory()));
        foreach (explode("\n", $content) as $line) {
            $parser->parseLine($line);
        }

        $playlist = $parser->getPlaylist();
        $this->assertEquals(2, $playlist->getVersion());
        $this->assertEquals(12, $playlist->getTargetduration());
        $this->assertEquals(33, $playlist->getMediaSequence());
        $this->assertEquals(3, $playlist->getDiscontinuitySequence());

        $segment = $playlist->getSegments()->offsetGet(0);
        $this->assertEquals('AES-128', $segment->getKeys()[0]->getMethod());
        $this->assertEquals('com.apple', $segment->getKeys()[1]->getKeyformat());
        $this->assertEquals('1', $segment->getKeys()[1]->getKeyformatversions());
        $this->assertEquals(12, $segment->getInf()->getDuration());
        $this->assertEquals('hello world', $segment->getInf()->getTitle());
        $this->assertEquals('stream33.ts', $segment->getUri());
        $this->assertEquals(10000, $segment->getByterange()->getLength());
        $this->assertEquals(100, $segment->getByterange()->getOffset());
        $this->assertFalse($segment->isDiscontinuity());

        $segment = $playlist->getSegments()->offsetGet(1);
        $this->assertEquals(10, $segment->getInf()->getDuration());
        $this->assertEquals('video01.ts', $segment->getUri());
        $this->assertTrue($segment->isDiscontinuity());

        $this->assertEquals(22, $playlist->getDuration());
    }

    public function testDump()
    {
        $playlist = DummyM3u8Factory::createM3u8(3);
        // var_dump($playlist); die();
        $dumper = new Dumper();

        $this->assertEquals(DummyM3u8Factory::createM3u8Content(3), $dumper->dump($playlist));
    }
}

