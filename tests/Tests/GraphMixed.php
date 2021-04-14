<?php
/**
 * Developer: alkis_stamos
 * Date: 4/3/16
 * Time: 3:48 PM
 */

namespace Nuad\Graph\Test\Tests;

use Nuad\Graph\Entity;
use Nuad\Graph\Graphable;
use Nuad\Graph\GraphAdapter;
use Nuad\Graph\Type;
use Nuad\Graph\TypeAdapter;

class GraphMixed implements Graphable
{
    use GraphAdapter;

    public $mixedStandard;
    public $mixedCustom;
    public $mixedCustomProperties;

    public static function create()
    {
        return new self();
    }

    public function graph()
    {
        return Entity::graph([
            'GraphMixed'
        ])->properties([
            'mixedStandard' => Type::Mixed(),
            'mixedCustom' => Type::Mixed(new CustomAdapterTest()),
            'mixedCustomProperties' => Type::Mixed(new CustomAdapterTest())
                ->apply([
                    'base' => Type::Object(GraphObjectBase::create())
                        ->bindTo(['objectNest.base']),
                    'simple' => Type::Object(GraphSimple::create()),
                    'mixedCustom',
                    'mixedCustom2' => 'nest.mixedCustom2'
                ])
        ]);
    }
}

class CustomAdapterTest implements TypeAdapter
{

    /**
     * All type adapters must map the data to a property using this method. The method should use the patter type and
     * map the from payload to the property.
     *
     * @param mixed $from The incoming data
     * @param Type $pattern The property type
     * @param string $name
     * @param mixed $scenario
     * @return mixed
     */
    public function map($from, Type $pattern, $name, $scenario)
    {
        return $from;
    }
}
