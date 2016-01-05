<?php
/**
 * Created by IntelliJ IDEA.
 * User: smiley
 * Date: 1/4/16
 * Time: 10:41 PM
 */

namespace Nuad\Graph\Test;


use Nuad\Graph\GraphAdapter;
use Nuad\Graph\Type;

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
        );
    }
}