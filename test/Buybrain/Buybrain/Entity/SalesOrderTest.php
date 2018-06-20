<?php
namespace Buybrain\Buybrain\Entity;

use Buybrain\Nervus\Entity;
use DateTimeImmutable;
use PHPUnit\Framework\TestCase;

class SalesOrderTest extends TestCase
{
    public function testToAndFromJson()
    {
        $order = new SalesOrder(
            '10005234',
            new DateTimeImmutable('2017-02-01 13:59:34+01:00'),
            'webshop',
            [
                new Sale('126', new DateTimeImmutable('2017-02-01 13:59:34+01:00'), 3),
                new Sale('62353', new DateTimeImmutable('2017-02-05 09:14:12+01:00'), 2),
                new Sale('126', new DateTimeImmutable('2017-02-05 09:14:12+01:00'), -2),
            ],
            [
                new Reservation('62353', new DateTimeImmutable('2017-02-05 09:14:12+01:00'), 1)
            ],
            [
                new OrderSkuPrice('126', new Money('EUR', 104.95)),
                new OrderSkuPrice('62353', new Money('EUR', 43)),
            ]
        );
        $order
            ->addSale(new Sale('123', new DateTimeImmutable('2017-02-10 12:00:00+01:00'), 1))
            ->addReservation(new Reservation('126', new DateTimeImmutable('2017-02-06 12:00:00+01:00'), 1))
            ->addPrice(new OrderSkuPrice('123', new Money('EUR', 1.5)))
            ->setOverheadCost(new Money('EUR', 4.2))
            ->setExtraFees(new Money('EUR', 4.95));

        $expectedJson = <<<'JSON'
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
    "reservations": [
        {
            "sku": "62353",
            "date": "2017-02-05T09:14:12+01:00",
            "quantity": 1
        },
        {
            "sku": "126",
            "date": "2017-02-06T12:00:00+01:00",
            "quantity": 1
        }
    ],
    "prices": [
        {
            "sku": "126",
            "price": {
                "currency": "EUR",
                "value": "104.95"
            }
        },
        {
            "sku": "62353",
            "price": {
                "currency": "EUR",
                "value": "43"
            }
        },
        {
            "sku": "123",
            "price": {
                "currency": "EUR",
                "value": "1.5"
            }
        }
    ],
    "extraFees": {
        "currency": "EUR",
        "value": "4.95"
    },
    "overheadCost": {
        "currency": "EUR",
        "value": "4.2"
    }
}
JSON;

        $this->assertEquals($expectedJson, json_encode($order, JSON_PRETTY_PRINT));

        $expectedEntity = new Entity(SalesOrder::id(10005234), json_encode($order));
        $this->assertEquals($expectedEntity, $order->asNervusEntity());

        $this->assertEquals($order, SalesOrder::fromJson(json_decode($expectedJson, true)));
    }
}
