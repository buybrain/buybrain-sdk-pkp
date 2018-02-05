<?php
namespace Buybrain\Buybrain\Entity;

use Buybrain\Nervus\Entity;
use DateTimeImmutable;
use PHPUnit\Framework\TestCase;

class SupplierOrderTest extends TestCase
{
    public function testToAndFromJson()
    {
        $order = new SupplierOrder(
            '10005234',
            '12345',
            new DateTimeImmutable('2017-02-01 13:59:34+01:00'),
            [
                new Purchase('126', new DateTimeImmutable('2017-02-01 13:59:34+01:00'), 3),
                new Purchase('126', new DateTimeImmutable('2017-02-05 09:14:12+01:00'), -2),
            ],
            [],
            [],
            [
                new SupplierOrderPrice('126', new Money('EUR', '10.0')),
                new SupplierOrderPrice('123', new Money('EUR', '11.0')),
            ]
        );
        $order
            ->addPurchase(new Purchase('123', new DateTimeImmutable('2017-02-10 12:00:00+01:00'), 2))
            ->addDelivery(new Delivery('126', new DateTimeImmutable('2017-02-06 12:00:00'), 1))
            ->addExpectedDelivery(new Delivery('123', new DateTimeImmutable('2017-02-11 12:00:00'), 1))
            ->addExpectedDelivery(new Delivery('123', new DateTimeImmutable('2017-02-12 12:00:00'), 1));

        $expectedJson = <<<'JSON'
{
    "id": "10005234",
    "supplierId": "12345",
    "createDate": "2017-02-01T13:59:34+01:00",
    "purchases": [
        {
            "sku": "126",
            "date": "2017-02-01T13:59:34+01:00",
            "quantity": 3
        },
        {
            "sku": "126",
            "date": "2017-02-05T09:14:12+01:00",
            "quantity": -2
        },
        {
            "sku": "123",
            "date": "2017-02-10T12:00:00+01:00",
            "quantity": 2
        }
    ],
    "deliveries": [
        {
            "sku": "126",
            "date": "2017-02-06T12:00:00+01:00",
            "quantity": 1
        }
    ],
    "expectedDeliveries": [
        {
            "sku": "123",
            "date": "2017-02-11T12:00:00+01:00",
            "quantity": 1
        },
        {
            "sku": "123",
            "date": "2017-02-12T12:00:00+01:00",
            "quantity": 1
        }
    ],
    "prices": [
        {
            "sku": "126",
            "price": {
                "currency": "EUR",
                "value": "10.0"
            }
        },
        {
            "sku": "123",
            "price": {
                "currency": "EUR",
                "value": "11.0"
            }
        }
    ]
}
JSON;

        $this->assertEquals($expectedJson, json_encode($order, JSON_PRETTY_PRINT));

        $expectedEntity = new Entity(SupplierOrder::id(10005234), json_encode($order));
        $this->assertEquals($expectedEntity, $order->asNervusEntity());

        $this->assertEquals($order, SupplierOrder::fromJson(json_decode($expectedJson, true)));
    }

    public function testToAndFromJsonWithAdviseInfo()
    {
        $order = new SupplierOrder(
            '10005234',
            '12345',
            new DateTimeImmutable('2017-02-01 13:59:34+01:00'),
            [new Purchase('126', new DateTimeImmutable('2017-02-01 13:59:34+01:00'), 3)]
        );
        $order->setUsedAdvise(new UsedAdviseInfo('00000000-0000-0000-0000-111111111111', 0.42));

        $expectedJson = <<<'JSON'
{
    "id": "10005234",
    "supplierId": "12345",
    "createDate": "2017-02-01T13:59:34+01:00",
    "purchases": [
        {
            "sku": "126",
            "date": "2017-02-01T13:59:34+01:00",
            "quantity": 3
        }
    ],
    "deliveries": [],
    "expectedDeliveries": [],
    "prices": [],
    "usedAdvise": {
        "adviseId": "00000000-0000-0000-0000-111111111111",
        "certainty": 0.42
    }
}
JSON;

        $this->assertEquals($expectedJson, json_encode($order, JSON_PRETTY_PRINT));

        $expectedEntity = new Entity(SupplierOrder::id(10005234), json_encode($order));
        $this->assertEquals($expectedEntity, $order->asNervusEntity());

        $this->assertEquals($order, SupplierOrder::fromJson(json_decode($expectedJson, true)));
    }
}
