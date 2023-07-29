<?php

namespace Sven\CommonMark\ImageMediaQueries\Tests\Renderer;

use PHPUnit\Framework\TestCase;
use Sven\CommonMark\ImageMediaQueries\Node\Picture;
use Sven\CommonMark\ImageMediaQueries\Renderer\PictureRenderer;

class PictureRendererTest extends TestCase
{
    public function testRenderingAPictureElement(): void
    {
        $r = new PictureRenderer();

        $output = $r->render(new Picture(), new NullRenderer());

        self::assertEquals('<picture></picture>', rtrim($output));
    }

    public function testRenderingAPictureElementWithAttributes(): void
    {
        $r = new PictureRenderer();

        $picture = new Picture();
        $picture->data->set('attributes', ['class' => 'test-class']);

        $output = $r->render($picture, new NullRenderer());

        self::assertEquals('<picture class="test-class"></picture>', rtrim($output));
    }
}
