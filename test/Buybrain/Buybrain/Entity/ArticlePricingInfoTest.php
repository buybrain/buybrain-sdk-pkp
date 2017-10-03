<?php
namespace Buybrain\Buybrain\Entity;

use Buybrain\Nervus\Entity;
use PHPUnit_Framework_TestCase;

class ArticlePricingInfoTest extends PHPUnit_Framework_TestCase
{
    public function testToJson()
    {
        $price = new ArticlePricingInfo(
            'abc-123',
            'shop',
            'NL',
            new Money('EUR', '12.34'),
            new Money('EUR', '4.091'),
            new Money('EUR', '1.612')
        );

        $expected = <<<'JSON'
{
    "sku": "abc-123",
    "channel": "shop",
    "sellingPrice": {
        "currency": "EUR",
        "value": "12.34"
    },
    "extraFees": {
        "currency": "EUR",
        "value": "4.091"
    },
    "overheadCost": {
        "currency": "EUR",
        "value": "1.612"
    },
    "subChannel": "NL"
}
JSON;

        $this->assertEquals($expected, json_encode($price, JSON_PRETTY_PRINT));

        $expectedEntity = new Entity(
            ArticlePricingInfo::id('abc-123|shop|NL'),
            json_encode($price)
        );
        $this->assertEquals($expectedEntity, $price->asNervusEntity());
    }

    public function testParsingAutoIDWithoutSubChannel()
    {
        $sku = 'abc-123';
        $channel = 'shop';

        $id = ArticlePricingInfo::getAutoId($sku, $channel);

        list($parsedSKU, $parsedChannel, $parsedSubChannel) = ArticlePricingInfo::parseAutoId($id);

        $this->assertEquals($sku, $parsedSKU);
        $this->assertEquals($channel, $parsedChannel);
        $this->assertNull($parsedSubChannel);
    }

    public function testParsingAutoIDWithSubChannel()
    {
        $sku = 'abc-123';
        $channel = 'shop';
        $subChannel = 'NL';

        $id = ArticlePricingInfo::getAutoId($sku, $channel, $subChannel);

        list($parsedSKU, $parsedChannel, $parsedSubChannel) = ArticlePricingInfo::parseAutoId($id);

        $this->assertEquals($sku, $parsedSKU);
        $this->assertEquals($channel, $parsedChannel);
        $this->assertEquals($subChannel, $parsedSubChannel);
    }
}
