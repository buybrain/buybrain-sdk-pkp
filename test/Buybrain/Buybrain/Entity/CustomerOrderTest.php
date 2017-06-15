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
            [
                new Sale('126', new DateTimeImmutable('2017-02-01 13:59:34+01:00'), 3, 'webshop/nl'),
                new Sale('62353', new DateTimeImmutable('2017-02-05 09:14:12+01:00'), 2, 'backoffice'),
                new Sale('126', new DateTimeImmutable('2017-02-05 09:14:12+01:00'), -2, 'backoffice'),
            ]
        );
        $order->addSale(new Sale('123', new DateTimeImmutable('2017-02-10 12:00:00+01:00'), 1, 'backoffice'));

        $expected = <<<'JSON'
{
    "id": "10005234",
    "createDate": "2017-02-01T13:59:34+01:00",
    "sales": [
        {
            "sku": "126",
            "date": "2017-02-01T13:59:34+01:00",
            "quantity": 3,
            "channel": "webshop\/nl"
        },
        {
            "sku": "62353",
            "date": "2017-02-05T09:14:12+01:00",
            "quantity": 2,
            "channel": "backoffice"
        },
        {
            "sku": "126",
            "date": "2017-02-05T09:14:12+01:00",
            "quantity": -2,
            "channel": "backoffice"
        },
        {
            "sku": "123",
            "date": "2017-02-10T12:00:00+01:00",
            "quantity": 1,
            "channel": "backoffice"
        }
    ]
}
JSON;

        $this->assertEquals($expected, json_encode($order, JSON_PRETTY_PRINT));

        $expectedEntity = new Entity(CustomerOrder::id(10005234), json_encode($order));
        $this->assertEquals($expectedEntity, $order->asNervusEntity());
    }
}
