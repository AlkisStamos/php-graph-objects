<?php
/**
 * Developer: alkis_stamos
 * Date: 3/29/16
 * Time: 10:07 PM
 */

namespace Nuad\Graph\Test;

class GraphExpectedTest extends \PHPUnit_Framework_TestCase
{
    public function testPreferredSelection()
    {
        $data = require 'mock/expected.php';
        $obj = GraphObjectExpected::map($data);
        $this->assertSame('string-bind-first',$obj->string);
        $this->assertSame(11,$obj->integer);
        $this->assertSame(11,$obj->simpleInteger);
        $this->assertSame('simple-string-bind-second',$obj->simpleString);
        foreach($obj->simpleCollection as $simpleObj)
        {
            $this->assertSame(22,$simpleObj->simpleInteger);
            $this->assertSame('simple-string-expected-second',$simpleObj->simpleString);
            $this->assertInstanceOf('Nuad\\Graph\\Test\\GraphSimple',$simpleObj);
        }
        $this->assertSame(2,$obj->simple->simpleInteger);
        $this->assertSame('simple-string-expected',$obj->simple->simpleString);
        $this->assertInstanceOf('Nuad\\Graph\\Test\\GraphSimple',$obj->simple);
    }

    public function testSecondaryExpectedValues()
    {
        $data = require 'mock/expected.php';
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
            $this->assertInstanceOf('Nuad\\Graph\\Test\\GraphSimple',$obj);
        }
        $this->assertSame(1,$obj->simple->simpleInteger);
        $this->assertSame('simple-string-default',$obj->simple->simpleString);
        $this->assertInstanceOf('Nuad\\Graph\\Test\\GraphSimple',$obj->simple);
    }
}