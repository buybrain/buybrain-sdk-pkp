<?php
namespace Buybrain\Buybrain\Entity;

use Buybrain\Buybrain\Entity\Supplier\PaymentCondition;
use Buybrain\Nervus\Entity;
use PHPUnit\Framework\TestCase;

class SupplierTest extends TestCase
{
    public function testToJson()
    {
        $supplier = new Supplier(
            '42',
            'Many Things inc.',
            2,
            [
                new PaymentCondition(15, 0.02),
                new PaymentCondition(30),
                new PaymentCondition(7, 0.05),
            ],
            false
        );

        $expected = <<<'JSON'
{
    "id": "42",
    "name": "Many Things inc.",
    "leadTime": 2,
    "paymentCond": [
        {
            "period": 30,
            "discount": 0
        },
        {
            "period": 15,
            "discount": 0.02
        },
        {
            "period": 7,
            "discount": 0.05
        }
    ],
    "assumeStock": false
}
JSON;
        $this->assertEquals($expected, json_encode($supplier, JSON_PRETTY_PRINT));

        $expectedEntity = new Entity(Supplier::id(42), json_encode($supplier));
        $this->assertEquals($expectedEntity, $supplier->asNervusEntity());
    }
}
