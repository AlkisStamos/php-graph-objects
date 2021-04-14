<?php
/**
 * Developer: alkis_stamos
 * Date: 3/28/16
 * Time: 12:21 AM
 */

namespace Nuad\Graph\Test\Tests;

use Nuad\Graph\Entity;
use Nuad\Graph\Graphable;
use Nuad\Graph\GraphAdapter;
use Nuad\Graph\Type;

class GraphObjectNestedData implements Graphable
{
    use GraphAdapter;

    public $_id;
    public $integer;
    public $array;
    public $anotherInteger;
    public $base;
    public $child;
    public $aProperty;

    public static function create()
    {
        return new self();
    }

    public function graph()
    {
        return Entity::graph([
            'GraphObjectNestedData'
        ])->properties([
            '_id' => Type::Integer()->bindTo(['id']),
            'integer'=> Type::Integer()->bindTo(['flatNest.integer']),
            'array' => Type::FlatArray()->bindTo(['flatNest.array']),
            'anotherInteger' => Type::Integer()->expected(['flatNest.nest.integer']),
            'base' => Type::Object(GraphObjectBase::create())->expected(['objectNest.base']),
            'child' => Type::Object(GraphObjectChild::create())->bindTo(['objectNest.nest.child']),
            'aProperty' => Type::Integer()->bindTo(['preferedproperty'])
        ]);
    }
}
