<?php

namespace Nuad\Graph\Test;


use Nuad\Graph\GraphAdapter;
use Nuad\Graph\Core\Type;

class GraphObjectChild extends GraphObjectBase
{
    use GraphAdapter;

    public $childValueStr;
    public $childValueBool;

    /**
     * @param string $aString
     * @param int $anInteger
     * @param bool|false $aBoolean
     * @param array $flatArray
     * @param float $aDouble
     * @param string $childValueStr
     * @param bool|false $childValueBool
     */
    public function __construct($aString='', $anInteger=0, $aBoolean=false, Array $flatArray=array(), $aDouble=0.0, $childValueStr='', $childValueBool=false)
    {
        parent::__construct($aString,$anInteger,$aBoolean,$flatArray,$aDouble);
        $this->childValueStr = $childValueStr;
        $this->childValueBool = $childValueBool;
        $this->childValueStr .= '_appendedByTheConstructor';
    }

    public function graph()
    {
        return parent::graph()->extend(
            ['GraphObjectChild']
        )
        ->properties(
            [
                'childValueStr' => Type::String()
                ->expected(array('child_val_str','cvsrt')),
                'childValueBool' => Type::Boolean()
                ->expected(array('child_val_bool'))
            ]
        )
        ->finalize(function($instance,$scenario)
        {
            if($scenario === 'test-finalize-map')
            {
                //when using map we are dealing with the same instance of the object and can use $this directly
                $this->childValueStr = $this->childValueStr.'__append_finalize_value';
                //but is safer to change the $instance values instead
                $instance->aDouble = ($instance->aDouble + 1.5);
            }
        });
    }
}