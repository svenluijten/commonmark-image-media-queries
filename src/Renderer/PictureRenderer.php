<?php

namespace Sven\CommonMark\ImageMediaQueries\Renderer;

use League\CommonMark\Node\Node;
use League\CommonMark\Renderer\ChildNodeRendererInterface;
use League\CommonMark\Renderer\NodeRendererInterface;
use League\CommonMark\Util\HtmlElement;
use Sven\CommonMark\ImageMediaQueries\Node\Picture;

final class PictureRenderer implements NodeRendererInterface
{
    public function render(Node $node, ChildNodeRendererInterface $childRenderer): HtmlElement
    {
        Picture::assertInstanceOf($node);

        /** @var array<string, string|string[]> $attrs */
        $attrs = $node->data->get('attributes');

        return new HtmlElement(
            tagName: 'picture',
            attributes: $attrs,
            contents: $childRenderer->renderNodes($node->children()),
        );
    }
}
