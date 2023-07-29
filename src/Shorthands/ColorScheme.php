<?php

namespace Sven\CommonMark\ImageMediaQueries\Shorthands;

final class ColorScheme implements Shorthand
{
    public function mediaQueries(): iterable
    {
        return [
            'scheme' => '(prefers-color-scheme: {})',
        ];
    }
}
