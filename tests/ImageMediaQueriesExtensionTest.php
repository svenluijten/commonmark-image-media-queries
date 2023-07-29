<?php

namespace Sven\CommonMark\ImageMediaQueries\Tests;

use League\CommonMark\Environment\Environment;
use League\CommonMark\Extension\CommonMark\CommonMarkCoreExtension;
use League\CommonMark\MarkdownConverter;
use PHPUnit\Framework\TestCase;
use RuntimeException;
use Spatie\Snapshots\MatchesSnapshots;
use Sven\CommonMark\ImageMediaQueries\ImageMediaQueriesExtension;

class ImageMediaQueriesExtensionTest extends TestCase
{
    use MatchesSnapshots;

    public function testRequiresTheAttributesExtension(): void
    {
        $environment = new Environment();
        $environment->addExtension(new CommonMarkCoreExtension());
        $environment->addExtension(new ImageMediaQueriesExtension());

        $converter = new MarkdownConverter($environment);

        $this->expectException(RuntimeException::class);

        $converter->convert('# test');
    }
}
