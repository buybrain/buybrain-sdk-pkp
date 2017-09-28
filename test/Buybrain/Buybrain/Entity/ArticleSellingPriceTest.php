<?php
namespace Buybrain\Buybrain\Entity;

use Buybrain\Nervus\Entity;
use PHPUnit_Framework_TestCase;

class ArticleSellingPriceTest extends PHPUnit_Framework_TestCase
{
    public function testToJson()
    {
        $price = new ArticleSellingPrice(
            'abc-123',
            'shop',
            'NL',
            new Money('EUR', '12.34')
        );

        $expected = <<<'JSON'
{
    "sku": "abc-123",
    "channel": "shop",
    "price": {
        "currency": "EUR",
        "value": "12.34"
    },
    "subChannel": "NL"
}
JSON;

        $this->assertEquals($expected, json_encode($price, JSON_PRETTY_PRINT));

        $expectedEntity = new Entity(
            ArticleSellingPrice::id('abc-123|shop|NL'),
            json_encode($price)
        );
        $this->assertEquals($expectedEntity, $price->asNervusEntity());
    }
}
