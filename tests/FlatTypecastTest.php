<?php
/**
 * Developer: alkis_stamos
 * Date: 4/3/16
 * Time: 10:11 AM
 */

namespace Nuad\Graph\Test;

use PHPUnit\Framework\TestCase;

class TestTypecast extends TestCase
{
    public function testTypecastNormal()
    {
        $data = Util::loadData('flat');
        $obj = GraphObjectBase::map($data['typecast_normal']);
        $this->assertSame('14', $obj->aString);
        $this->assertSame(5, $obj->anInteger);
        $this->assertSame(true, $obj->aBoolean);
        $this->assertTrue(Util::arrays_are_similar(array('property'=>1, 'otherProperty'=>2), $obj->flatArray));
        $this->assertSame(2.0, $obj->aDouble);
        $this->assertInstanceOf('Nuad\\Graph\\Test\\GraphObjectBase',$obj);
    }

    public function testTypecastDiff()
    {
        $data = Util::loadData('flat');
        $obj = GraphObjectBase::map($data['typecast_diff']);
        $this->assertSame('true', $obj->aString);
        $this->assertSame(1, $obj->anInteger);
        $this->assertSame(true, $obj->aBoolean);
        $this->assertTrue(Util::arrays_are_similar(array(), $obj->flatArray));
        $this->assertSame(-0.6, $obj->aDouble);
        $this->assertInstanceOf('Nuad\\Graph\\Test\\GraphObjectBase',$obj);
    }

    public function testTypecastFail()
    {
        $data = Util::loadData('flat');
        $obj = GraphObjectBase::map($data['typecast_fail']);
        $this->assertSame(null, $obj->aString);
        $this->assertSame(null, $obj->anInteger);
        $this->assertSame(null, $obj->aBoolean);
        $this->assertSame(null, $obj->flatArray);
        $this->assertSame(null, $obj->aDouble);
        $this->assertInstanceOf('Nuad\\Graph\\Test\\GraphObjectBase',$obj);
    }
}