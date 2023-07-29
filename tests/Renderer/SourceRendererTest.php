<?php

namespace Sven\CommonMark\ImageMediaQueries\Tests\Renderer;

use PHPUnit\Framework\TestCase;
use Sven\CommonMark\ImageMediaQueries\Node\Source;
use Sven\CommonMark\ImageMediaQueries\Renderer\SourceRenderer;

class SourceRendererTest extends TestCase
{
    public function testRenderingASourceElement(): void
    {
        $r = new SourceRenderer();

        $output = $r->render(new Source('https://example.com', '(prefers-color-scheme: dark)'), new NullRenderer());

        self::assertEquals('<source media="(prefers-color-scheme: dark)" srcset="https://example.com" />', rtrim($output));
    }
}
