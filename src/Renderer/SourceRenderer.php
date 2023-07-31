<?php

namespace Sven\CommonMark\ImageMediaQueries\Renderer;

use League\CommonMark\Node\Node;
use League\CommonMark\Renderer\ChildNodeRendererInterface;
use League\CommonMark\Renderer\NodeRendererInterface;
use League\CommonMark\Util\HtmlElement;
use Sven\CommonMark\ImageMediaQueries\Node\Source;

class SourceRenderer implements NodeRendererInterface
{
    public function render(Node $node, ChildNodeRendererInterface $childRenderer): HtmlElement
    {
        /** @var \Sven\CommonMark\ImageMediaQueries\Node\Source $node */
        Source::assertInstanceOf($node);

        /** @var array<string, string|string[]> $existingAttributes */
        $existingAttributes = $node->data->get('attributes');

        $attributes = [
            'media' => $node->getMedia(),
            'srcset' => $node->getUrl(),
            ...$existingAttributes,
        ];

        return new HtmlElement('source', $attributes, selfClosing: true);
    }
}
