<?php

namespace Nuad\Graph\Test;

use Nuad\Graph\Core\Entity;
use Nuad\Graph\Graphable;
use Nuad\Graph\GraphAdapter;
use Nuad\Graph\Core\Type;

class GraphObjectList implements Graphable
{
    use GraphAdapter;

    public $assoc;
    public $nest;
    public $baseList;

    /**
     * GraphObjectList constructor.
     * @param $assoc
     * @param $nest
     * @param $baseList
     */
    public function __construct(Array $assoc=array(), GraphObjectNest $nest=null, Array $baseList=array())
    {
        $this->assoc = $assoc;
        $this->nest = $nest;
        $this->baseList = $baseList;
    }


    public function graph()
    {
        return Entity::graph(
            ['GraphObjectList']
        )
        ->properties(
            [
                'assoc'     => Type::FlatArray(),
                'nest'      => Type::Object(GraphObjectNest::create()),
                'baseList'  => Type::Collection(GraphObjectBase::create())
            ]
        );
    }
}