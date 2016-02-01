<?php

namespace Nuad\Graph\Test;

use Nuad\Graph\Entity;
use Nuad\Graph\Graphable;
use Nuad\Graph\GraphAdapter;
use Nuad\Graph\Type;

class GraphObjectStep implements Graphable
{
    use GraphAdapter;

    public $nested;
    public $child;
    public $list;
    public $property;
    public $anotherProperty;

    /**
     * @param GraphObjectNest|null $nested
     * @param GraphObjectChild|null $child
     * @param GraphObjectList|null $list
     * @param string $property
     * @param int $anotherProperty
     */
    public function __construct(GraphObjectNest $nested=null, GraphObjectChild $child=null, GraphObjectList $list=null, $property='', $anotherProperty=0)
    {
        $this->nested = $nested;
        $this->child = $child;
        $this->list = $list;
        $this->property = $property;
        $this->anotherProperty = $anotherProperty;
    }

    public function graph()
    {
        return Entity::graph(
            [
                'GraphObjectStep'
            ]
        )->properties(
            [
                'nested' =>             Type::Object(GraphObjectNest::create()),
                'child'  =>             Type::Object(GraphObjectChild::create()),
                'list'   =>             Type::Object(GraphObjectList::create()),
                'property' =>           Type::String()->expected(array('someProperty')),
                'anotherProperty' =>    Type::Integer()->expected(array('someOtherProperty'))
            ]
        );
    }
}