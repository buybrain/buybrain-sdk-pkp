<?php
namespace Buybrain\Buybrain\Entity;

use Buybrain\Nervus\Entity;
use DateTimeImmutable;
use PHPUnit_Framework_TestCase;

class CustomerOrderTest extends PHPUnit_Framework_TestCase
{
    public function testToJson()
    {
        $order = new CustomerOrder(
            '10005234',
            new DateTimeImmutable('2017-02-01 13:59:34+01:00'),
            'webshop',
            [
                new Sale('126', new DateTimeImmutable('2017-02-01 13:59:34+01:00'), 3),
                new Sale('62353', new DateTimeImmutable('2017-02-05 09:14:12+01:00'), 2),
                new Sale('126', new DateTimeImmutable('2017-02-05 09:14:12+01:00'), -2),
            ]
        );
        $order
            ->addSale(new Sale('123', new DateTimeImmutable('2017-02-10 12:00:00+01:00'), 1))
            ->addShipment(new Shipment('126', new DateTimeImmutable('2017-02-06 12:00:00'), 1));

        $expected = <<<'JSON'
{
    "id": "10005234",
    "createDate": "2017-02-01T13:59:34+01:00",
    "channel": "webshop",
    "sales": [
        {
            "sku": "126",
            "date": "2017-02-01T13:59:34+01:00",
            "quantity": 3
        },
        {
            "sku": "62353",
            "date": "2017-02-05T09:14:12+01:00",
            "quantity": 2
        },
        {
            "sku": "126",
            "date": "2017-02-05T09:14:12+01:00",
            "quantity": -2
        },
        {
            "sku": "123",
            "date": "2017-02-10T12:00:00+01:00",
            "quantity": 1
        }
    ],
    "shipments": [
        {
            "sku": "126",
            "date": "2017-02-06T12:00:00+01:00",
            "quantity": 1
        }
    ]
}
JSON;

        $this->assertEquals($expected, json_encode($order, JSON_PRETTY_PRINT));

        $expectedEntity = new Entity(CustomerOrder::id(10005234), json_encode($order));
        $this->assertEquals($expectedEntity, $order->asNervusEntity());
    }
}
