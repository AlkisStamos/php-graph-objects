<?php

namespace Nuad\Graph\Test;

class GraphAdapterCallbackTest extends \PHPUnit_Framework_TestCase
{
    public function testCallbacksWithScenario()
    {
        $data = require 'mock/child_expected.php';
        $scenario = 'test-scenario';
        $obj = GraphObjectGrandChildWithCallbacks::map($data,$scenario);
        $this->assertSame('astringvalue', $obj->aString);
        $this->assertSame(5, $obj->anInteger);
        $this->assertSame(false, $obj->aBoolean);
        $this->assertTrue(Util::arrays_are_similar(array('a', 'b', 'c', 'd'), $obj->flatArray));
        $this->assertSame(5.5, $obj->aDouble);
        $this->assertSame($scenario.'child_val_str'.'anotherstringvalue', $obj->childValueStr);
        $this->assertSame(true,$obj->childValueBool);
        $this->assertInstanceOf('Nuad\\Graph\\Test\\GraphObjectChild',$obj);
    }

    public function testNonCallbackOverrideScenario()
    {
        $data = require 'mock/child_expected.php';
        $scenario = 'test-normal-scenario';
        $obj = GraphObjectGrandChildWithCallbacks::map($data,$scenario);
        $this->assertSame('astringvalue', $obj->aString);
        $this->assertSame(5, $obj->anInteger);
        $this->assertSame(false, $obj->aBoolean);
        $this->assertTrue(Util::arrays_are_similar(array('a', 'b', 'c', 'd'), $obj->flatArray));
        $this->assertSame(5.5, $obj->aDouble);
        $this->assertSame('anotherstringvalue', $obj->childValueStr);
        $this->assertSame(true,$obj->childValueBool);
        $this->assertInstanceOf('Nuad\\Graph\\Test\\GraphObjectChild',$obj);
    }
}