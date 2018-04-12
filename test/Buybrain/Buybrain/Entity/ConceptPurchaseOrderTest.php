<?php
namespace Buybrain\Buybrain\Entity;

use Buybrain\Nervus\Entity;
use DateTimeImmutable;
use PHPUnit\Framework\TestCase;

class ConceptPurchaseOrderTest extends TestCase
{
    public function testToAndFromJson()
    {
        $concept = new ConceptPurchaseOrder(
            '00000000-0000-0000-0000-222222222222',
            '12345',
            new DateTimeImmutable('2017-02-01 13:59:34+01:00'),
            [
                new ConceptPurchaseOrderArticle('123', 1, new Money('EUR', 2.23)),
                new ConceptPurchaseOrderArticle('234', '5', new Money('EUR', 3.34))
            ],
            new Money('EUR', 5)
        );

        $expectedJson = <<<'JSON'
{
    "id": "00000000-0000-0000-0000-222222222222",
    "supplierId": "12345",
    "createDate": "2017-02-01T13:59:34+01:00",
    "articles": [
        {
            "sku": "123",
            "quantity": 1,
            "itemPrice": {
                "currency": "EUR",
                "value": "2.23"
            }
        },
        {
            "sku": "234",
            "quantity": 5,
            "itemPrice": {
                "currency": "EUR",
                "value": "3.34"
            }
        }
    ],
    "shippingCost": {
        "currency": "EUR",
        "value": "5"
    },
    "status": "pending"
}
JSON;

        $this->assertEquals($expectedJson, json_encode($concept, JSON_PRETTY_PRINT));

        $expectedEntity = new Entity(
            ConceptPurchaseOrder::id('00000000-0000-0000-0000-222222222222'),
            json_encode($concept)
        );
        $this->assertEquals($expectedEntity, $concept->asNervusEntity());

        $this->assertEquals($concept, ConceptPurchaseOrder::fromJson(json_decode($expectedJson, true)));
    }
}
