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
use PHPUnit\Framework\TestCase;
use Chrisyue\PhpM3u8\Parser\PlaylistComponentFactory;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Chrisyue\PhpM3u8\Parser\Parser;
use Chrisyue\PhpM3u8\Parser\PlaylistBuilder;
use Chrisyue\PhpM3u8\Parser\TagMetadataBag;
use Chrisyue\PhpM3u8\Parser\Event\TagEvent;
use Chrisyue\PhpM3u8\Dumper\Dumper;

class ParserTest extends TestCase
{
    public function testParseLine()
    {
        $parser = $this->createParser();
        $content = DummyM3u8Factory::createM3u8Content();
        foreach (explode("\n", $content) as $line) {
            $parser->parseLine($line);
        }

        $playlist = $parser->getPlaylist();

        echo $this->createDumper()->dump($playlist);
    }

    private function createParser()
    {
        $factory = new PlaylistComponentFactory();
        $builder = new PlaylistBuilder($factory, new EventDispatcher);

        return new Parser($builder, new TagMetadataBag());
    }

    private function createDumper()
    {
        return new Dumper(new TagMetadataBag());
    }
}
