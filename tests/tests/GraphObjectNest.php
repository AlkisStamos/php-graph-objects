<?php

namespace Nuad\Graph\Test;


use Nuad\Graph\Entity;
use Nuad\Graph\Graphable;
use Nuad\Graph\GraphAdapter;
use Nuad\Graph\Type;

class GraphObjectNest implements Graphable
{
    use GraphAdapter;

    public $child;
    public $ownProperty;

    /**
     * GraphObjectNest constructor.
     * @param $child
     * @param $ownProperty
     */
    public function __construct(GraphObjectChild $child=null, $ownProperty='')
    {
        $this->child = $child;
        $this->ownProperty = $ownProperty;
    }

    public function graph()
    {
        return Entity::graph(
            ['GraphObjectNest']
        )
        ->properties(
            [
                'child'         => Type::Object(GraphObjectChild::create()),
                'ownProperty'   => Type::String()
            ]
        );
    }
}