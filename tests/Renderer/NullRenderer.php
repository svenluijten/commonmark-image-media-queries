<?php

namespace Sven\CommonMark\ImageMediaQueries\Tests\Renderer;

use League\CommonMark\Node\Block\Document;
use League\CommonMark\Output\RenderedContent;
use League\CommonMark\Output\RenderedContentInterface;
use League\CommonMark\Renderer\ChildNodeRendererInterface;
use League\CommonMark\Renderer\DocumentRendererInterface;

class NullRenderer implements ChildNodeRendererInterface, DocumentRendererInterface
{
    public function renderNodes(iterable $nodes): string
    {
        return '';
    }

    public function getBlockSeparator(): string
    {
        return '';
    }

    public function getInnerSeparator(): string
    {
        return '';
    }

    public function renderDocument(Document $document): RenderedContentInterface
    {
        return new RenderedContent($document, '');
    }
}
