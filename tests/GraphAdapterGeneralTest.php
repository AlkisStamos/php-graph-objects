<?php

namespace Nuad\Graph\Test;


class GraphAdapterGeneralTest extends \PHPUnit_Framework_TestCase
{
    public function testMapObjectBase()
    {
        $data = require 'mock/base.php';
        $obj = GraphObjectBase::map($data);
        $this->assertSame('astringvalue', $obj->aString);
        $this->assertSame(5, $obj->anInteger);
        $this->assertSame(false, $obj->aBoolean);
        $this->assertTrue(Util::arrays_are_similar(array('a', 'b', 'c', 'd'), $obj->flatArray));
        $this->assertSame(5.5, $obj->aDouble);
        $this->assertInstanceOf('Nuad\\Graph\\Test\\GraphObjectBase',$obj);
    }

    public function testInjectObjectBase()
    {
        $data = require 'mock/base.php';
        $obj = GraphObjectBase::inject($data);
        $this->assertSame('astringvalue', $obj->aString);
        $this->assertSame(7, $obj->anInteger);
        $this->assertSame(false, $obj->aBoolean);
        $this->assertTrue(Util::arrays_are_similar(array('a', 'b', 'c', 'd'), $obj->flatArray));
        $this->assertSame(5.5, $obj->aDouble);
        $this->assertInstanceOf('Nuad\\Graph\\Test\\GraphObjectBase',$obj);
    }

    public function testInjectObjectBase_withTypecast()
    {
        $data = require 'mock/base_weak_types.php';
        $obj = GraphObjectBase::map($data);
        $this->assertSame('astringvalue', $obj->aString);
        $this->assertSame(5, $obj->anInteger);
        $this->assertSame(false, $obj->aBoolean);
        $this->assertTrue(Util::arrays_are_similar(array('a', 'b', 'c', 'd'), $obj->flatArray));
        $this->assertSame(5.5, $obj->aDouble);
        $this->assertInstanceOf('Nuad\\Graph\\Test\\GraphObjectBase',$obj);
    }

    public function testMapInheritance()
    {
        $data = require 'mock/child.php';
        $obj = GraphObjectChild::map($data);
        $this->assertSame('astringvalue', $obj->aString);
        $this->assertSame(5, $obj->anInteger);
        $this->assertSame(false, $obj->aBoolean);
        $this->assertTrue(Util::arrays_are_similar(array('a', 'b', 'c', 'd'), $obj->flatArray));
        $this->assertSame(5.5, $obj->aDouble);
        $this->assertSame('anotherstringvalue', $obj->childValueStr);
        $this->assertSame(true,$obj->childValueBool);
        $this->assertInstanceOf('Nuad\\Graph\\Test\\GraphObjectChild',$obj);
    }

    public function testInjectInheritance()
    {
        $data = require 'mock/child.php';
        $obj = GraphObjectChild::inject($data);
        $this->assertSame('astringvalue', $obj->aString);
        $this->assertSame(7, $obj->anInteger);
        $this->assertSame(false, $obj->aBoolean);
        $this->assertTrue(Util::arrays_are_similar(array('a', 'b', 'c', 'd'), $obj->flatArray));
        $this->assertSame(5.5, $obj->aDouble);
        $this->assertSame('anotherstringvalue_appendedByTheConstructor', $obj->childValueStr);
        $this->assertSame(true,$obj->childValueBool);
        $this->assertInstanceOf('Nuad\\Graph\\Test\\GraphObjectChild',$obj);
    }

    public function testInjectInheritance_withExpectedValues()
    {
        $data = require 'mock/child_expected.php';
        $obj = GraphObjectChild::inject($data);
        $this->assertSame('astringvalue', $obj->aString);
        $this->assertSame(7, $obj->anInteger);
        $this->assertSame(false, $obj->aBoolean);
        $this->assertTrue(Util::arrays_are_similar(array('a', 'b', 'c', 'd'), $obj->flatArray));
        $this->assertSame(5.5, $obj->aDouble);
        $this->assertSame('anotherstringvalue_appendedByTheConstructor', $obj->childValueStr);
        $this->assertSame(true,$obj->childValueBool);
        $this->assertInstanceOf('Nuad\\Graph\\Test\\GraphObjectChild',$obj);
    }

    public function testMapEmpty()
    {
        $dataBase = require 'mock/base_weak_types.php';
        $dataChild = require 'mock/chid_parent_diff.php';
        $obj = GraphObjectChild::map($dataBase);
        $obj->mapEmpty($dataChild);
        $this->assertSame('astringvalue', $obj->aString);
        $this->assertSame(5, $obj->anInteger);
        $this->assertSame(false, $obj->aBoolean);
        $this->assertTrue(Util::arrays_are_similar(array('a', 'b', 'c', 'd'), $obj->flatArray));
        $this->assertSame(5.5, $obj->aDouble);
        $this->assertSame('anotherstringvaluewithdiff', $obj->childValueStr);
        $this->assertSame(false,$obj->childValueBool);
        $this->assertInstanceOf('Nuad\\Graph\\Test\\GraphObjectChild',$obj);
    }

    public function testNestedMapping()
    {
        $data = require 'mock/nested.php';
        $obj = GraphObjectNest::map($data);
        $this->assertSame('thisisastringnested',$obj->ownProperty);
        $this->assertSame('astringvalue', $obj->child->aString);
        $this->assertSame(12, $obj->child->anInteger);
        $this->assertSame(true, $obj->child->aBoolean);
        $this->assertTrue(Util::arrays_are_similar(array('a', 'b', 'c', 'd'), $obj->child->flatArray));
        $this->assertSame(10.5, $obj->child->aDouble);
        $this->assertSame('anotherstringvaluewithdiff', $obj->child->childValueStr);
        $this->assertSame(false,$obj->child->childValueBool);
        $this->assertInstanceOf('Nuad\\Graph\\Test\\GraphObjectNest',$obj);
    }

    public function testListMapping()
    {
        $data = require 'mock/list.php';
        $obj = GraphObjectList::map($data);
        $this->assertArrayHasKey('one',$obj->assoc);
        $this->assertArrayHasKey('two',$obj->assoc);
        $this->assertArrayHasKey('three',$obj->assoc);
        $this->assertSame('thisisastringnested',$obj->nest->ownProperty);
        $this->assertSame('astringvalue', $obj->nest->child->aString);
        $this->assertSame(12, $obj->nest->child->anInteger);
        $this->assertSame(true, $obj->nest->child->aBoolean);
        $this->assertTrue(Util::arrays_are_similar(array('a', 'b', 'c', 'd'), $obj->nest->child->flatArray));
        $this->assertSame(10.5, $obj->nest->child->aDouble);
        $this->assertSame('anotherstringvaluewithdiff', $obj->nest->child->childValueStr);
        $this->assertSame(false,$obj->nest->child->childValueBool);
        $this->assertInstanceOf('Nuad\\Graph\\Test\\GraphObjectNest',$obj->nest);
        $this->assertInstanceOf('Nuad\\Graph\\Test\\GraphObjectList',$obj);
        foreach($obj->baseList as $index=>$item)
        {
            $this->assertListIteration($index,$item);
        }
    }

    public function testDefaultValue()
    {
        $data = require 'mock/child.php';
        unset($data['aDouble']);
        $obj = GraphObjectChild::inject($data);
        $this->assertSame('astringvalue', $obj->aString);
        $this->assertSame(7, $obj->anInteger);
        $this->assertSame(false, $obj->aBoolean);
        $this->assertTrue(Util::arrays_are_similar(array('a', 'b', 'c', 'd'), $obj->flatArray));
        $this->assertSame(20.0, $obj->aDouble);
        $this->assertSame('anotherstringvalue_appendedByTheConstructor', $obj->childValueStr);
        $this->assertSame(true,$obj->childValueBool);
        $this->assertInstanceOf('Nuad\\Graph\\Test\\GraphObjectChild',$obj);
    }

    public function testMixedValue()
    {
        $data = require 'mock/simple.php';
        $obj = GraphSimple::map($data);
        $this->assertSame(5,$obj->simpleInteger);
        $this->assertSame('a sample string',$obj->simpleString);
        $this->assertInstanceOf('Nuad\\Graph\\Test\\GraphSimple',$obj->simpleMixed);
        $this->assertSame(10,$obj->simpleMixed->simpleInteger);
        $this->assertSame('another sample string',$obj->simpleMixed->simpleString);
        $this->assertTrue(Util::arrays_are_similar(array(1,2,3), $obj->simpleMixed->simpleMixed));
        unset($data['simple-mixed']);
        $obj = GraphSimple::map($data);
        $this->assertSame(5,$obj->simpleInteger);
        $this->assertSame('a sample string',$obj->simpleString);
        $this->assertSame('123',$obj->simpleMixed);
    }

    private function assertListIteration($index, GraphObjectBase $obj)
    {
        $this->assertSame('astringvalue'.$index,$obj->aString);
        $this->assertSame($index,$obj->anInteger);
        $this->assertSame(($index+0.5),$obj->aDouble);
        $this->assertTrue(Util::arrays_are_similar(array('a', 'b', 'c', 'd'), $obj->flatArray));
        $this->assertSame(false, $obj->aBoolean);
        $this->assertInstanceOf('Nuad\\Graph\\Test\\GraphObjectBase',$obj);
    }
}
