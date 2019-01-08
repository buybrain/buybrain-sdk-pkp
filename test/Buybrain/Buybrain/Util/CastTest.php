<?php
namespace Buybrain\Buybrain\Util;

use PHPUnit\Framework\TestCase;

class CastTest extends TestCase
{
    public function testCastToString()
    {
        $this->assertEquals('abc', Cast::toString('abc'));
        $this->assertEquals('123', Cast::toString(123));
        $this->assertEquals(null, Cast::toString(null));
        $this->assertEquals(['1', 'a', '1', ['b', null]], Cast::toString([1, 'a', true, ['b', null]]));
    }

    public function testCastToInt()
    {
        $this->assertEquals(123, Cast::toInt('123'));
        $this->assertEquals(123, Cast::toInt(123));
        $this->assertEquals(null, Cast::toInt(null));
        $this->assertEquals([1, 2, 1, [3, null]], Cast::toInt([1, '2', true, [3, null]]));
    }
}
