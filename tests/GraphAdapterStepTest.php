<?php

namespace Nuad\Graph\Test;


class GraphAdapterStepTest extends \PHPUnit_Framework_TestCase
{
    public function testMapObjectStepByStep_withEmpty()
    {
        $obj = GraphObjectStep::createEmpty();

        $this->assertInstanceOf('Nuad\\Graph\\Test\\GraphObjectStep',$obj);

        $nestedData = Util::loadData('nested');
        $obj->mapProperty($nestedData,'nested');
        $this->assertNested($obj->nested);
        $this->assertNull($obj->child);
        $this->assertNull($obj->list);
        $this->assertNull($obj->property);
        $this->assertNull($obj->anotherProperty);

        $childData = Util::loadData('child');
        $obj->mapProperty($childData,'child');
        $this->assertChild($obj->child);
        $this->assertNested($obj->nested);
        $this->assertNull($obj->list);
        $this->assertNull($obj->property);
        $this->assertNull($obj->anotherProperty);

        $listData = Util::loadData('list');
        $obj->mapProperty($listData,'list');
        $this->assertList($obj->list);
        $this->assertChild($obj->child);
        $this->assertNested($obj->nested);
        $this->assertNull($obj->property);
        $this->assertNull($obj->anotherProperty);

        $extraData = Util::loadData('step_properties');
        $obj->mapEmpty($extraData);
        $this->assertList($obj->list);
        $this->assertChild($obj->child);
        $this->assertNested($obj->nested);
        $this->assertSame('aproperty',$obj->property);
        $this->assertEquals(1,$obj->anotherProperty);
        $this->assertInstanceOf('Nuad\\Graph\\Test\\GraphObjectStep',$obj);
    }

    public function testMapObjectStepByStep_withCreated()
    {
        $extraData = Util::loadData('step_properties');
        $obj = GraphObjectStep::map($extraData);
        $this->assertInstanceOf('Nuad\\Graph\\Test\\GraphObjectStep',$obj);
        $this->assertSame('aproperty',$obj->property);
        $this->assertEquals(1,$obj->anotherProperty);
        $this->assertNull($obj->child);
        $this->assertNull($obj->list);
        $this->assertNull($obj->nested);

        $nestedData = Util::loadData('nested');
        $obj->mapEmpty(array('nested'=>$nestedData));
        $this->assertInstanceOf('Nuad\\Graph\\Test\\GraphObjectStep',$obj);
        $this->assertSame('aproperty',$obj->property);
        $this->assertEquals(1,$obj->anotherProperty);
        $this->assertNested($obj->nested);
        $this->assertNull($obj->child);
        $this->assertNull($obj->list);

        $listData = Util::loadData('list');
        $obj->mapEmpty(array('list'=>$listData));
        $this->assertInstanceOf('Nuad\\Graph\\Test\\GraphObjectStep',$obj);
        $this->assertSame('aproperty',$obj->property);
        $this->assertEquals(1,$obj->anotherProperty);
        $this->assertNested($obj->nested);
        $this->assertList($obj->list);
        $this->assertNull($obj->child);

        $childData = Util::loadData('child');
        $obj->mapEmpty(array('child'=>$childData));
        $this->assertInstanceOf('Nuad\\Graph\\Test\\GraphObjectStep',$obj);
        $this->assertSame('aproperty',$obj->property);
        $this->assertEquals(1,$obj->anotherProperty);
        $this->assertNested($obj->nested);
        $this->assertList($obj->list);
        $this->assertChild($obj->child);
        return $obj;
    }

    public function testMapObjectStepByStep_changeStepValue()
    {
        $obj = $this->testMapObjectStepByStep_withCreated();
        $diffChildData = Util::loadData('child_parent_diff');
        $obj->mapProperty($diffChildData,'child');
        $this->assertInstanceOf('Nuad\\Graph\\Test\\GraphObjectStep',$obj);
        $this->assertSame('aproperty',$obj->property);
        $this->assertEquals(1,$obj->anotherProperty);
        $this->assertNested($obj->nested);
        $this->assertList($obj->list);
        $this->assertDiffChild($obj->child);
    }

    private function assertNested($obj)
    {
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

    private function assertChild($obj)
    {
        $this->assertSame('astringvalue', $obj->aString);
        $this->assertSame(5, $obj->anInteger);
        $this->assertSame(false, $obj->aBoolean);
        $this->assertTrue(Util::arrays_are_similar(array('a', 'b', 'c', 'd'), $obj->flatArray));
        $this->assertSame(5.5, $obj->aDouble);
        $this->assertSame('anotherstringvalue', $obj->childValueStr);
        $this->assertSame(true,$obj->childValueBool);
        $this->assertInstanceOf('Nuad\\Graph\\Test\\GraphObjectChild',$obj);
    }

    private function assertDiffChild($obj)
    {
        $this->assertSame('adiffvalue', $obj->aString);
        $this->assertSame(12, $obj->anInteger);
        $this->assertSame(true, $obj->aBoolean);
        $this->assertTrue(Util::arrays_are_similar(array('e','f','g','h'), $obj->flatArray));
        $this->assertSame(10.5, $obj->aDouble);
        $this->assertSame('anotherstringvaluewithdiff', $obj->childValueStr);
        $this->assertSame(false,$obj->childValueBool);
        $this->assertInstanceOf('Nuad\\Graph\\Test\\GraphObjectChild',$obj);
    }

    private function assertList($obj)
    {
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