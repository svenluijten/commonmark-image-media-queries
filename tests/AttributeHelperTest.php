<?php

namespace Sven\CommonMark\ImageMediaQueries\Tests;

use League\CommonMark\Extension\CommonMark\Node\Inline\Image;
use PHPUnit\Framework\TestCase;
use Sven\CommonMark\ImageMediaQueries\AttributeHelper;

class AttributeHelperTest extends TestCase
{
    public function testRemoveAttributesFromNode(): void
    {
        $node = new Image('https://example.com');
        $node->data->set('attributes', [
            'class' => '::test::',
            'alt' => '::alt text::',
            'scheme' => '::dark::',
        ]);

        /** @var array<string, string> $attributes */
        $attributes = $node->data->get('attributes');

        $this->assertArrayHasKey('class', $attributes);
        $this->assertArrayHasKey('alt', $attributes);
        $this->assertArrayHasKey('scheme', $attributes);

        AttributeHelper::removeFromNode($node, ['scheme', 'alt']);

        /** @var array<string, string> $newAttributes */
        $newAttributes = $node->data->get('attributes');

        $this->assertArrayHasKey('class', $newAttributes);
        $this->assertArrayNotHasKey('alt', $newAttributes);
        $this->assertArrayNotHasKey('scheme', $newAttributes);
    }
}
