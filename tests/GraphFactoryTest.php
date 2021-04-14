<?php
/**
 * Developer: alkis_stamos
 * Date: 1/10/2017
 * Time: 8:49 PM
 */

namespace Nuad\Graph\Test;
use Nuad\Graph\Entity;
use Nuad\Graph\Graphable;
use Nuad\Graph\GraphFactory;
use Nuad\Graph\Test\Tests\GraphObjectBase;
use PHPUnit\Framework\TestCase;

class GraphFactoryTest extends TestCase
{
    public function testSameObjectMap()
    {
        $baseData = Util::loadData('base');
        $obj = GraphObjectBase::map($baseData);
        $this->assertSame('astringvalue', $obj->aString);
        $this->assertSame(5, $obj->anInteger);
        $this->assertSame(false, $obj->aBoolean);
        $this->assertTrue(Util::arrays_are_similar(array('a', 'b', 'c', 'd'), $obj->flatArray));
        $this->assertSame(5.5, $obj->aDouble);
        $this->assertInstanceOf(GraphObjectBase::class,$obj);

        unset($baseData['anInteger']);
        unset($baseData['aBoolean']);
        $baseData['aString'] = 'anotherStringValue';
        $obj2 = GraphObjectBase::create();
        $test = GraphObjectBase::injectWithInstance($obj2,$baseData);
//        $obj2 = GraphObjectBase::map($baseData);
        $this->assertSame('anotherStringValue', $obj2->aString);
        $this->assertNull($obj2->anInteger);
        $this->assertNull($obj2->aBoolean);
        $this->assertTrue(Util::arrays_are_similar(array('a', 'b', 'c', 'd'), $obj2->flatArray));
        $this->assertSame(5.5, $obj2->aDouble);
        $this->assertInstanceOf(GraphObjectBase::class,$obj2);

        $this->assertNotSame($obj,$obj2);
    }

    public function testCacheInstanceDiff()
    {
        $obj1 = GraphObjectBase::create();
        $obj2 = GraphObjectBase::create();
        $this->assertNotSame($obj1,$obj2);

        $this->assertInstanceOf(\ReflectionClass::class,GraphFactory::getReflection(GraphObjectBase::class));
//        $this->assertInstanceOf(Entity::class,GraphFactory::getGraph(GraphObjectBase::class));
        $this->assertInstanceOf(Graphable::class,GraphFactory::getInstance(GraphObjectBase::class));

        $this->assertEquals($obj1,GraphFactory::getInstance(GraphObjectBase::class));
    }
}
