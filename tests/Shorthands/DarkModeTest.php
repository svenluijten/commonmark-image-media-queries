<?php

namespace Sven\CommonMark\ImageMediaQueries\Tests\Shorthands;

use League\CommonMark\Extension\ExtensionInterface;
use Sven\CommonMark\ImageMediaQueries\ImageMediaQueriesExtension;
use Sven\CommonMark\ImageMediaQueries\Shorthands\ColorScheme;
use Sven\CommonMark\ImageMediaQueries\Tests\MarkdownTestCase;

class DarkModeTest extends MarkdownTestCase
{
    public static function dataProvider(): iterable
    {
        yield '2 images with light and dark attributes' => [
            <<<MD
![image one](/example-dark.jpg){scheme=dark}
![image two](/example-light.jpg){scheme=light}
MD,
        ];

        yield '2 images without dark or light attributes' => [<<<MD
![image one](/example-one.jpg)
![image two](/example-two.jpg)
MD,
        ];

        yield '2 picture elements' => [<<<MD
![image one dark](/example-one-dark.jpg){scheme=dark}
![image one light](/example-one-light.jpg){scheme=light}

![image two dark](/example-two-dark.jpg){scheme=dark}
![image two light](/example-two-light.jpg){scheme=light}
MD,
        ];
    }

    protected function getExtension(): ExtensionInterface
    {
        $extension = new ImageMediaQueriesExtension();
        $extension->addShorthand(new ColorScheme());

        return $extension;
    }
}
