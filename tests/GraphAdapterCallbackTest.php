<?php

namespace Nuad\Graph\Test;

class GraphAdapterCallbackTest extends \PHPUnit_Framework_TestCase
{
    public function testCallbacksWithScenario()
    {
        $data = Util::loadData('child_expected');
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
        $data = Util::loadData('child_expected');
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

    public function testFinalizeInject()
    {
        $data = Util::loadData('base');
        $obj = GraphObjectBase::inject($data,'test-finalize-inject');
        $this->assertSame('thisisthefinalizedstring', $obj->aString);
        $this->assertSame(7, $obj->anInteger);
        $this->assertSame(false, $obj->aBoolean);
        $this->assertTrue(Util::arrays_are_similar(array('a', 'b', 'c', 'd'), $obj->flatArray));
        $this->assertSame(7.0, $obj->aDouble);
        $this->assertInstanceOf('Nuad\\Graph\\Test\\GraphObjectBase',$obj);
    }

    public function testFinalizeMap()
    {
        $data = Util::loadData('child');
        $obj = GraphObjectChild::map($data,'test-finalize-map');
        $this->assertSame('astringvalue', $obj->aString);
        $this->assertSame(5, $obj->anInteger);
        $this->assertSame(false, $obj->aBoolean);
        $this->assertTrue(Util::arrays_are_similar(array('a', 'b', 'c', 'd'), $obj->flatArray));
        $this->assertSame(7.0, $obj->aDouble);
        $this->assertSame('anotherstringvalue__append_finalize_value', $obj->childValueStr);
        $this->assertSame(true,$obj->childValueBool);
        $this->assertInstanceOf('Nuad\\Graph\\Test\\GraphObjectChild',$obj);
    }
}