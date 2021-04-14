<?php
/**
 * Developer: alkis_stamos
 * Date: 3/28/16
 * Time: 12:38 AM
 */

namespace Nuad\Graph\Test;

use Nuad\Graph\Test\Tests\GraphObjectBase;
use Nuad\Graph\Test\Tests\GraphObjectChild;
use Nuad\Graph\Test\Tests\GraphObjectNest;
use Nuad\Graph\Test\Tests\GraphObjectNestedData;
use PHPUnit\Framework\TestCase;

class NestedDataTest extends TestCase
{
    public function testNestedDataMap()
    {
        $data = Util::loadData('nested_data');
        $obj = GraphObjectNestedData::map($data);
        $this->assertSame(65987,$obj->_id);
        $this->assertSame(17,$obj->integer);
        $this->assertTrue(Util::arrays_are_similar(array('12', '13', '14'), $obj->array));
        $this->assertSame(356,$obj->anotherInteger);

        $this->assertInstanceOf(GraphObjectBase::class,$obj->base);
        $this->assertSame('astringvalue', $obj->base->aString);
        $this->assertSame(5, $obj->base->anInteger);
        $this->assertSame(false, $obj->base->aBoolean);
        $this->assertTrue(Util::arrays_are_similar(array('a', 'b', 'c', 'd'), $obj->base->flatArray));
        $this->assertSame(5.5, $obj->base->aDouble);

        $this->assertInstanceOf(GraphObjectChild::class,$obj->child);
        $this->assertSame('astringvalue', $obj->child->aString);
        $this->assertSame(5, $obj->child->anInteger);
        $this->assertSame(false, $obj->child->aBoolean);
        $this->assertTrue(Util::arrays_are_similar(array('a', 'b', 'c', 'd'), $obj->child->flatArray));
        $this->assertSame(5.5, $obj->child->aDouble);
        $this->assertSame('anotherstringvalue', $obj->child->childValueStr);
        $this->assertSame(true,$obj->child->childValueBool);

        $this->assertInstanceOf(GraphObjectNestedData::class,$obj);
    }

    public function testNestedMapping()
    {
        $data = Util::loadData('nested');
        $obj = GraphObjectNest::map($data);
        $this->assertSame('thisisastringnested',$obj->ownProperty);
        $this->assertSame('astringvalue', $obj->child->aString);
        $this->assertSame(12, $obj->child->anInteger);
        $this->assertSame(true, $obj->child->aBoolean);
        $this->assertTrue(Util::arrays_are_similar(array('a', 'b', 'c', 'd'), $obj->child->flatArray));
        $this->assertSame(10.5, $obj->child->aDouble);
        $this->assertSame('anotherstringvaluewithdiff', $obj->child->childValueStr);
        $this->assertSame(false,$obj->child->childValueBool);
        $this->assertInstanceOf(GraphObjectNest::class,$obj);
    }
}
