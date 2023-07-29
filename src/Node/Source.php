<?php

namespace Sven\CommonMark\ImageMediaQueries\Node;

use League\CommonMark\Node\Node;

final class Source extends Node
{
    private string $url;
    private string $media;

    public function __construct(string $url, string $query)
    {
        parent::__construct();

        $this->url = $url;
        $this->media = $query;
    }

    public function getUrl(): string
    {
        return $this->url;
    }

    public function getMedia(): string
    {
        return $this->media;
    }
}
