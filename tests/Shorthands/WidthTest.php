<?php

namespace Sven\CommonMark\ImageMediaQueries\Tests\Shorthands;

use League\CommonMark\Extension\ExtensionInterface;
use Sven\CommonMark\ImageMediaQueries\ImageMediaQueriesExtension;
use Sven\CommonMark\ImageMediaQueries\Shorthands\Width;
use Sven\CommonMark\ImageMediaQueries\Tests\MarkdownTestCase;

class WidthTest extends MarkdownTestCase
{
    public static function dataProvider(): iterable
    {
        yield 'image with "minw" attribute' => [
            <<<'MD'
![1000](/1000.jpg){minw=1000px}
![default](/default.jpg)
MD,
        ];

        yield 'multiple images with different "minw" attributes' => [
            <<<'MD'
![1000](/1000.jpg){minw=1000px}
![800](/800.jpg){minw=800px}
![560](/560.jpg){minw=560px}
![default](/default.jpg)
MD,
        ];

        yield 'image with "maxw" attribute' => [
            <<<'MD'
![600](/600.jpg){maxw=600px}
![default](/default.jpg)
MD,
        ];

        yield 'multiple images with different "maxw" attributes' => [
            <<<'MD'
![1000](/1000.jpg){maxw=1000px}
![800](/800.jpg){maxw=800px}
![560](/560.jpg){maxw=560px}
![default](/default.jpg)
MD,
        ];
    }

    protected function getExtension(): ExtensionInterface
    {
        $extension = new ImageMediaQueriesExtension();
        $extension->addShorthand(new Width());

        return $extension;
    }
}
