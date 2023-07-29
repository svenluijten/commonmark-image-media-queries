<?php

namespace Sven\CommonMark\ImageMediaQueries\Shorthands;

final class Width implements Shorthand
{
    public function mediaQueries(): iterable
    {
        return [
            'minw' => '(min-width: {})',
            'maxw' => '(max-width: {})',
        ];
    }
}
