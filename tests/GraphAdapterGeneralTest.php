<?php

namespace Nuad\Graph\Test;


use PHPUnit\Framework\TestCase;

class GraphAdapterGeneralTest extends TestCase
{
    public function testMapObjectBase()
    {
        $data = Util::loadData('base');
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
        $data = Util::loadData('base');
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
        $data = Util::loadData('base_weak_types');
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
        $data = Util::loadData('child');
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
        $data = Util::loadData('child');
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
        $dataBase = Util::loadData('base_weak_types');
        $dataChild = Util::loadData('child_parent_diff');
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

    public function testListMapping()
    {
        $data = Util::loadData('list');
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
        $data = Util::loadData('child');
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
