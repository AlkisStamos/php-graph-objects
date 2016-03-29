<?php
/**
 * Developer: alkis_stamos
 * Date: 3/29/16
 * Time: 9:32 PM
 */

namespace Nuad\Graph\Test;

use Nuad\Graph\Entity;
use Nuad\Graph\Graphable;
use Nuad\Graph\GraphAdapter;
use Nuad\Graph\Type;

class GraphSimple implements Graphable
{
    use GraphAdapter;

    public $simpleInteger;
    public $simpleString;

    public static function create()
    {
        return new self();
    }

    public function graph()
    {
        return Entity::graph([
            'GraphSimple'
        ])->properties([
            'simpleInteger'     => Type::Integer()
            ->bindTo(['simple-integer','simple_integer'])
            ->expected(['simpleInt','simple-int']),
            'simpleString'      => Type::String()
            ->bindTo(['simple-string','simple_string'])
            ->expected(['simpleString','simple-str'])
        ]);
    }
}