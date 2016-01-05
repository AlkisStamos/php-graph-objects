<?php
/**
 * Created by IntelliJ IDEA.
 * User: smiley
 * Date: 1/4/16
 * Time: 8:12 PM
 */

namespace Nuad\Graph\Test;

use Nuad\Graph\Entity;
use Nuad\Graph\Graphable;
use Nuad\Graph\GraphAdapter;
use Nuad\Graph\Type;

class GraphObjectBase implements Graphable
{
    use GraphAdapter;

    public $aString;
    public $anInteger;
    public $aBoolean;
    public $flatArray;
    public $aDouble;

    /**
     * GraphObjectBase constructor.
     * @param $aString
     * @param $anInteger
     * @param $aBoolean
     * @param $flatArray
     * @param $aDouble
     */
    public function __construct($aString='', $anInteger=0, $aBoolean=false, Array $flatArray=array(), $aDouble=0.0)
    {
        $this->aString = $aString;
        $this->anInteger = $anInteger;
        $this->aBoolean = $aBoolean;
        $this->flatArray = $flatArray;
        $this->aDouble = $aDouble;
        $this->anInteger += 2;
    }

    public function graph()
    {
        return Entity::graph
        (
            ['GraphObjectBase']
        )
        ->properties(
            [
                'aString'       => Type::String(),
                'anInteger'     => Type::Integer()
                ->expected(array('integer_val')),
                'aBoolean'      => Type::Boolean(),
                'flatArray'     => Type::FlatArray(),
                'aDouble'       => Type::Double()
            ]
        );
    }
}