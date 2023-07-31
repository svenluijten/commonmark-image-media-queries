<?php

namespace Sven\CommonMark\ImageMediaQueries;

use League\CommonMark\Node\Node;

class AttributeHelper
{
    /**
     * @param  Node  $node
     * @param  string[]  $attributes
     * @return void
     */
    public static function removeFromNode(Node $node, array $attributes): void
    {
        foreach ($attributes as $attr) {
            $node->data->remove('attributes/'.$attr);
        }
    }
}
