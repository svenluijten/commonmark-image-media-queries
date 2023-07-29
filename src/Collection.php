<?php

namespace Sven\CommonMark\ImageMediaQueries;

final class Collection
{
    /**
     * @var array<string, string>
     */
    private array $shorthands = [];

    public function add(string $attribute, string $query): void
    {
        $this->shorthands[$attribute] = $query;
    }

    public function get(string $attribute): string
    {
        return $this->shorthands[$attribute];
    }

    /**
     * @return string[]
     */
    public function attributes(): array
    {
        return array_keys($this->shorthands);
    }
}
