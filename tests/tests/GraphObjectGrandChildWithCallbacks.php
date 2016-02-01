<?php

namespace Nuad\Graph\Test;

use Nuad\Graph\Graphable;
use Nuad\Graph\GraphAdapter;
use Nuad\Graph\Type;

class GraphObjectGrandChildWithCallbacks extends GraphObjectChild implements Graphable
{
    use GraphAdapter;

    public static $override_scenario = 'test-scenario';

    public function graph()
    {
        return parent::graph()->extend(
            [
                'GraphObjectGrandChildWithCallbacks'
            ]
        )->properties([
            'childValueStr' =>      Type::String()->handler(function($data,$name,$scenario)
            {
                if($scenario === self::$override_scenario)
                {
                    return $scenario.$name.$data;
                }
                return null;
            })->expected(array('child_val_str'))
        ]);
    }
}