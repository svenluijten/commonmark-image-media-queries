<?php

namespace Sven\CommonMark\ImageMediaQueries\Shorthands;

interface Shorthand
{
    /**
     * @return iterable<string, string>
     */
    public function mediaQueries(): iterable;
}
