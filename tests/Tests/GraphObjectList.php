<?php

namespace Nuad\Graph\Test\Tests;

use Nuad\Graph\Entity;
use Nuad\Graph\Graphable;
use Nuad\Graph\GraphAdapter;
use Nuad\Graph\Test\GraphObjectNest;
use Nuad\Graph\Type;

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
                'nest'      => Type::Object(\Nuad\Graph\Test\Tests\GraphObjectNest::create()),
                'baseList'  => Type::Collection(GraphObjectBase::create())
            ]
        );
    }
}
