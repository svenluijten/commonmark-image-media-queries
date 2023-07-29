<?php

namespace Sven\CommonMark\ImageMediaQueries\Tests;

use League\CommonMark\Environment\Environment;
use League\CommonMark\Extension\Attributes\AttributesExtension;
use League\CommonMark\Extension\CommonMark\CommonMarkCoreExtension;
use League\CommonMark\Extension\ExtensionInterface;
use League\CommonMark\MarkdownConverter;
use PHPUnit\Framework\TestCase;
use Spatie\Snapshots\MatchesSnapshots;

abstract class MarkdownTestCase extends TestCase
{
    use MatchesSnapshots;

    /**
     * @return iterable<string, array<int, string>>
     */
    abstract public static function dataProvider(): iterable;

    /** @dataProvider dataProvider */
    public function testImages(string $markdown): void
    {
        $extension = $this->getExtension();

        $environment = new Environment();
        $environment->addExtension(new CommonMarkCoreExtension());
        $environment->addExtension(new AttributesExtension());
        $environment->addExtension($extension);

        $converter = new MarkdownConverter($environment);

        $output = rtrim((string)$converter->convert($markdown));

        $this->assertMatchesSnapshot($output);
    }

    abstract protected function getExtension(): ExtensionInterface;
}
