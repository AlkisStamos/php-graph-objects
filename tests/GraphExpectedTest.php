<?php
/**
 * Developer: alkis_stamos
 * Date: 3/29/16
 * Time: 10:07 PM
 */

namespace Nuad\Graph\Test;

use Nuad\Graph\Test\Tests\GraphObjectChild;
use Nuad\Graph\Test\Tests\GraphObjectExpected;
use Nuad\Graph\Test\Tests\GraphSimple;
use PHPUnit\Framework\TestCase;

class GraphExpectedTest extends TestCase
{
    public function testPreferredSelection()
    {
        $data = Util::loadData('expected');
        $obj = GraphObjectExpected::map($data);
        $this->assertSame('string-bind-first',$obj->string);
        $this->assertSame(11,$obj->integer);
        $this->assertSame(11,$obj->simpleInteger);
        $this->assertSame('simple-string-bind-second',$obj->simpleString);
        foreach($obj->simpleCollection as $simpleObj)
        {
            $this->assertSame(22,$simpleObj->simpleInteger);
            $this->assertSame('simple-string-expected-second',$simpleObj->simpleString);
            $this->assertInstanceOf(GraphSimple::class,$simpleObj);
        }
        $this->assertSame(2,$obj->simple->simpleInteger);
        $this->assertSame('simple-string-expected',$obj->simple->simpleString);
        $this->assertInstanceOf(GraphSimple::class,$obj->simple);
    }

    public function testSecondaryExpectedValues()
    {
        $data = Util::loadData('expected');
        unset($data['simpleInteger']);
        unset($data['simple-integer']);
        unset($data['simple_integer']);
        unset($data['simpleInt']);
        unset($data['simpleString']);
        unset($data['simple_string']);
        unset($data['alphanumeric']);
        unset($data['str']);
        unset($data['__string']);
        unset($data['string__']);
        unset($data['string']);
        unset($data['integer']);
        unset($data['int']);
        unset($data['__integer']);
        unset($data['simpleCollection']);
        unset($data['simples']);
        unset($data['simple']);

        $obj = GraphObjectExpected::map($data);
        $this->assertSame('string-expected-third',$obj->string);
        $this->assertSame(22,$obj->integer);
        $this->assertSame(22,$obj->simpleInteger);
        $this->assertSame('simple-string-expected-second',$obj->simpleString);
        foreach($obj->simpleCollection as $simpleObj)
        {
            $this->assertSame(11,$simpleObj->simpleInteger);
            $this->assertSame('simple-string-expected-second2',$simpleObj->simpleString);
            $this->assertInstanceOf(GraphSimple::class,$obj);
        }
        $this->assertSame(1,$obj->simple->simpleInteger);
        $this->assertSame('simple-string-default',$obj->simple->simpleString);
        $this->assertInstanceOf(GraphSimple::class,$obj->simple);
    }

    public function testInjectInheritance_withExpectedValues()
    {
        $data = Util::loadData('child_expected');
        $obj = GraphObjectChild::inject($data);
        $this->assertSame('astringvalue', $obj->aString);
        $this->assertSame(7, $obj->anInteger);
        $this->assertSame(false, $obj->aBoolean);
        $this->assertTrue(Util::arrays_are_similar(array('a', 'b', 'c', 'd'), $obj->flatArray));
        $this->assertSame(5.5, $obj->aDouble);
        $this->assertSame('anotherstringvalue_appendedByTheConstructor', $obj->childValueStr);
        $this->assertSame(true,$obj->childValueBool);
        $this->assertInstanceOf(GraphObjectChild::class,$obj);
    }
}
