<?php
/**
 * Developer: alkis_stamos
 * Date: 4/3/16
 * Time: 8:36 PM
 */

namespace Nuad\Graph\Test;

use PHPUnit\Framework\TestCase;

class MixedTypeTest extends TestCase
{
    public function testMixedValue()
    {
        $data = Util::loadData('simple');
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

    public function testCustomAdapterMixedValue()
    {
        $data = Util::loadData('mixed');
        $obj = GraphMixed::map($data);

        $this->assertInstanceOf('stdClass',$obj->mixedStandard);
        $this->assertSame(1,$obj->mixedStandard->property);
        $this->assertSame(2,$obj->mixedStandard->otherProperty);

        $this->assertArrayHasKey('mixedStandard',$obj->mixedCustom);
        $this->assertArrayHasKey('objectNest',$obj->mixedCustom);
        $this->assertArrayHasKey('base',$obj->mixedCustom['objectNest']);
        $this->assertArrayHasKey('simple',$obj->mixedCustom);
        $this->assertArrayHasKey('mixedCustom',$obj->mixedCustom);
        $this->assertArrayHasKey('nest',$obj->mixedCustom);
        $this->assertArrayHasKey('mixedCustom2',$obj->mixedCustom['nest']);
        $base = GraphObjectBase::map($obj->mixedCustom['objectNest']['base']);
        $this->assertSame('astringvalue', $base->aString);
        $this->assertSame(5, $base->anInteger);
        $this->assertSame(false, $base->aBoolean);
        $this->assertTrue(Util::arrays_are_similar(array('a', 'b', 'c', 'd'), $base->flatArray));
        $this->assertSame(5.5, $base->aDouble);
        $this->assertInstanceOf('Nuad\\Graph\\Test\\GraphObjectBase',$base);
        $simple = GraphSimple::map($obj->mixedCustom['simple']);
        $this->assertSame(5,$simple->simpleInteger);
        $this->assertSame('a sample string',$simple->simpleString);
        $this->assertSame('123',$simple->simpleMixed);
        $this->assertInstanceOf('Nuad\\Graph\\Test\\GraphSimple',$simple);

        $this->assertArrayHasKey('base',$obj->mixedCustomProperties);
        $this->assertArrayHasKey('simple',$obj->mixedCustomProperties);
        $this->assertArrayHasKey('mixedCustom',$obj->mixedCustomProperties);
        $this->assertArrayHasKey('mixedCustom2',$obj->mixedCustomProperties);
        $this->assertInstanceOf('Nuad\\Graph\\Test\\GraphObjectBase',$obj->mixedCustomProperties['base']);
        $this->assertSame('astringvalue', $obj->mixedCustomProperties['base']->aString);
        $this->assertSame(5, $obj->mixedCustomProperties['base']->anInteger);
        $this->assertSame(false, $obj->mixedCustomProperties['base']->aBoolean);
        $this->assertTrue(Util::arrays_are_similar(array('a', 'b', 'c', 'd'), $obj->mixedCustomProperties['base']->flatArray));
        $this->assertSame(5.5, $obj->mixedCustomProperties['base']->aDouble);
        $this->assertInstanceOf('Nuad\\Graph\\Test\\GraphSimple',$obj->mixedCustomProperties['simple']);
        $this->assertSame(5,$obj->mixedCustomProperties['simple']->simpleInteger);
        $this->assertSame('a sample string',$obj->mixedCustomProperties['simple']->simpleString);
        $this->assertSame('123',$obj->mixedCustomProperties['simple']->simpleMixed);
        $this->assertSame('avalue',$obj->mixedCustomProperties['mixedCustom']);
        $this->assertSame('anotherValue',$obj->mixedCustomProperties['mixedCustom2']);
    }
}