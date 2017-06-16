<?php
namespace Buybrain\Buybrain\Entity;

use Buybrain\Nervus\Entity;
use DateTimeImmutable;
use PHPUnit_Framework_TestCase;

class StockItemTest extends PHPUnit_Framework_TestCase
{
    public function testToJson()
    {
        $item = new StockItem(
            '42',
            'abc-123',
            new DateTimeImmutable('2017-01-01Z'),
            null
        );

        $expected = <<<'JSON'
{
    "id": "42",
    "sku": "abc-123",
    "startDate": "2017-01-01T00:00:00+00:00",
    "endDate": null
}
JSON;

        $this->assertEquals($expected, json_encode($item, JSON_PRETTY_PRINT));

        $expectedEntity = new Entity(StockItem::id(42), json_encode($item));
        $this->assertEquals($expectedEntity, $item->asNervusEntity());
    }
}
