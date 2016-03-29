<?php
/**
 * Developer: alkis_stamos
 * Date: 3/29/16
 * Time: 9:28 PM
 */

namespace Nuad\Graph\Test;

use Nuad\Graph\GraphAdapter;
use Nuad\Graph\Type;

class GraphObjectExpected extends GraphSimple
{
    use GraphAdapter;

    public $string;
    public $integer;
    /**
     * @var GraphSimple[]
     */
    public $simpleCollection;
    /**
     * @var GraphSimple
     */
    public $simple;


    public static function create()
    {
        return new self();
    }

    public function graph()
    {
        return parent::graph()->extend([
            'GraphObjectExpected'
        ])->properties([
            'string'    => Type::String()
            ->bindTo(['str','alphanumeric'])
            ->expected(['__string','string__','str_val']),
            'integer'   => Type::Integer()
            ->bindTo(['int'])
            ->expected(['__integer','__int','int_val']),
            'simpleCollection' => Type::Collection(GraphSimple::create())
            ->bindTo(['simple_collection','simples'])
            ->expected(['simpleData','simple_data','simple-data']),
            'simple'     => Type::Object(GraphSimple::create())
            ->bindTo(['GraphSimple','simple-val','simple.nested'])
            ->expected(['__simple','simple__','nested.simple'])
        ]);
    }
}