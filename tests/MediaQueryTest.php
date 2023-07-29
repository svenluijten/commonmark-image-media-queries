<?php

namespace Sven\CommonMark\ImageMediaQueries\Tests;

use League\CommonMark\Extension\ExtensionInterface;
use Sven\CommonMark\ImageMediaQueries\ImageMediaQueriesExtension;

class MediaQueryTest extends MarkdownTestCase
{
    public static function dataProvider(): iterable
    {
        yield 'no image tags' => [
            'test',
        ];

        yield 'an image tag without siblings' => [
            '![test](/example.jpg)',
        ];

        yield 'an image with 2 (non-image) siblings' => [
            <<<MD
# test header
![test](/example.jpg)
test text
MD,
        ];

        yield 'single image with media query' => [
            <<<MD
![large](/large.jpg){media="(min-width: 1000px)"}
MD,
        ];

        yield '2 images where one has a media query' => [
            <<<MD
![large](/large.jpg){media="(min-width: 1000px)"}
![medium](/medium.jpg)
MD,
        ];

        yield 'multiple images with media queries' => [
            <<<MD
![1200](/1200.jpg){media="(min-width: 1200px)"}
![800](/800.jpg){media="(min-width: 800px)"}
![480](/480.jpg){media="(min-width: 480px)"}
![The actual image and the alt that will be used](/default.jpg)
MD,
        ];

        yield 'additional attributes' => [
            <<<MD
![large](/large.jpg){media="(min-width: 1000px)" type="image/jpeg"}
![medium](/medium.jpg)
MD,
        ];
    }

    protected function getExtension(): ExtensionInterface
    {
        return new ImageMediaQueriesExtension();
    }
}
