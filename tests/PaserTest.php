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
        $content = DummyM3u8Factory::createMediaPlaylistContent(2);

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

        $content = DummyM3u8Factory::createMasterPlaylistContent();
        $parser = new Parser(new PlaylistBuilder(new PlaylistComponentFactory()));
        foreach (explode("\n", $content) as $line) {
            $parser->parseLine($line);
        }

        $playlist = $parser->getPlaylist();
        $this->assertEquals(true, $playlist->isIndependentSegments());
        $this->assertEquals(1.1, $playlist->getStart()->getTimeOffset());
        $this->assertEquals('YES', $playlist->getStart()->getPrecise());
        $this->assertEquals('AUDIO', $playlist->getMedias()[0]->getType());
        $this->assertEquals('media.uri', $playlist->getMedias()[0]->getUri());
        $this->assertEquals('group', $playlist->getMedias()[0]->getGroupId());
        $this->assertEquals('zh-Hans', $playlist->getMedias()[0]->getLanguage());
        $this->assertEquals('zh-Hans', $playlist->getMedias()[0]->getAssocLanguage());
        $this->assertEquals('name', $playlist->getMedias()[0]->getName());
        $this->assertEquals('YES', $playlist->getMedias()[0]->getDefault());
        $this->assertEquals('YES', $playlist->getMedias()[0]->getAutoselect());
        $this->assertEquals('NO', $playlist->getMedias()[0]->getForced());
        $this->assertEquals('CC1', $playlist->getMedias()[0]->getInstreamId());
        $this->assertEquals('public.easy-to-read', $playlist->getMedias()[0]->getCharacteristics());
        $this->assertEquals('6', $playlist->getMedias()[0]->getChannels());
    }

    public function testDump()
    {
        $playlist = DummyM3u8Factory::createMediaPlaylist(3);
        $dumper = new Dumper();

        $this->assertEquals(DummyM3u8Factory::createMediaPlaylistContent(3), $dumper->dump($playlist));
    }
}

