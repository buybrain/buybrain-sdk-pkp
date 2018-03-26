<?php
namespace Buybrain\Buybrain\Entity;

use Buybrain\Buybrain\Util\DateTimes;
use PHPUnit\Framework\TestCase;

class PoAdviceTest extends TestCase
{
    public function testToAndFromJson()
    {
        $advice = new PoAdvice(
            '123',
            '456',
            DateTimes::parse('2018-01-01Z'),
            DateTimes::parse('2018-02-01Z'),
            DateTimes::parse('2018-03-01Z'),
            new Money('EUR', 5),
            [
                new PoAdviceArticle('1', 1, 0, new Money('EUR', 1)),
                new PoAdviceArticle('2', 2, 1, new Money('EUR', 2)),
            ],
            0.90,
            0.85
        );

        $expectedJson = <<<'JSON'
{
    "id": "123",
    "supplierId": "456",
    "createDate": "2018-01-01T00:00:00+00:00",
    "deliveryDate": "2018-02-01T00:00:00+00:00",
    "nextDeliveryDate": "2018-03-01T00:00:00+00:00",
    "shippingCost": {
        "currency": "EUR",
        "value": "5"
    },
    "articles": [
        {
            "sku": "1",
            "quantity": 1,
            "minimumQuantity": 0,
            "price": {
                "currency": "EUR",
                "value": "1"
            }
        },
        {
            "sku": "2",
            "quantity": 2,
            "minimumQuantity": 1,
            "price": {
                "currency": "EUR",
                "value": "2"
            }
        }
    ],
    "efficiency": 0.9,
    "zeroItemsEfficiency": 0.85
}
JSON;

        $this->assertEquals($expectedJson, json_encode($advice, JSON_PRETTY_PRINT));

        $this->assertEquals($advice, PoAdvice::fromJson(json_decode($expectedJson, true)));
    }
}
