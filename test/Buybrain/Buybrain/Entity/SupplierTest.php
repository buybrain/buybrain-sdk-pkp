<?php
namespace Buybrain\Buybrain\Entity;

use Buybrain\Nervus\Entity;
use PHPUnit\Framework\TestCase;

class SupplierTest extends TestCase
{
    public function testToJson()
    {
        $supplier = new Supplier(
            '42',
            'Many Things inc.',
            2
        );

        $expected = <<<'JSON'
{
    "id": "42",
    "name": "Many Things inc.",
    "leadTime": 2
}
JSON;

        $this->assertEquals($expected, json_encode($supplier, JSON_PRETTY_PRINT));

        $expectedEntity = new Entity(Supplier::id(42), json_encode($supplier));
        $this->assertEquals($expectedEntity, $supplier->asNervusEntity());
    }
}
