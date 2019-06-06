<?php
namespace Buybrain\Buybrain\Util;

use Buybrain\Buybrain\Exception\InvalidArgumentException;
use DateTimeImmutable;
use PHPUnit\Framework\TestCase;

class LocalDateTest extends TestCase
{
    public function testValidDate()
    {
        $date = new LocalDate(2019, 6, 1);
        $this->assertEquals([2019, 6, 1], [$date->getYear(), $date->getMonth(), $date->getDay()]);
    }

    public function testInvalidDate()
    {
        $this->expectException(InvalidArgumentException::class);
        new LocalDate(2019, 6, 31);
    }

    public function testFormat()
    {
        $date = new LocalDate(2019, 6, 11);
        $this->assertEquals('2019-06-11', $date->format());
    }

    public function testParseValid()
    {
        $parsed = LocalDate::parse('2019-06-01');
        $this->assertEquals(new LocalDate(2019, 6, 1), $parsed);
    }

    public function testParseInvalid()
    {
        $this->expectException(InvalidArgumentException::class);
        LocalDate::parse('2019-6-01');
    }

    public function testFromDateTime()
    {
        $dateTime = new DateTimeImmutable('2019-06-01T00:00:00+01:00');
        $this->assertEquals(new LocalDate(2019, 6, 1), LocalDate::fromDateTime($dateTime));
    }
}
