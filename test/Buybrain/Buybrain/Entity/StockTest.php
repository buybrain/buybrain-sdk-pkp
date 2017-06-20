<?php
namespace Buybrain\Buybrain\Entity;

use Buybrain\Nervus\Entity;
use DateTimeImmutable;
use PHPUnit_Framework_TestCase;

class StockTest extends PHPUnit_Framework_TestCase
{
    public function testToJson()
    {
        $item = new Stock(
            'abc-123',
            new DateTimeImmutable('2017-01-01Z'),
            42
        );

        $expected = <<<'JSON'
{
    "sku": "abc-123",
    "date": "2017-01-01T00:00:00+00:00",
    "stock": 42
}
JSON;

        $this->assertEquals($expected, json_encode($item, JSON_PRETTY_PRINT));

        $expectedEntity = new Entity(Stock::id('abc-123|2017-01-01T00:00:00+00:00'), json_encode($item));
        $this->assertEquals($expectedEntity, $item->asNervusEntity());
    }

    public function testToJsonWithCustomId()
    {
        $item = new Stock(
            'abc-123',
            new DateTimeImmutable('2017-01-01Z'),
            42
        );
        $item->setId('1234');

        $expected = <<<'JSON'
{
    "sku": "abc-123",
    "date": "2017-01-01T00:00:00+00:00",
    "stock": 42,
    "id": "1234"
}
JSON;

        $this->assertEquals($expected, json_encode($item, JSON_PRETTY_PRINT));

        $expectedEntity = new Entity(Stock::id('1234'), json_encode($item));
        $this->assertEquals($expectedEntity, $item->asNervusEntity());
    }
}
