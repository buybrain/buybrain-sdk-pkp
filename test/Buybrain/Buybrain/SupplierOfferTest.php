<?php
namespace Buybrain\Buybrain;

use Buybrain\Nervus\Entity;
use Buybrain\Nervus\EntityId;
use DateTimeImmutable;
use PHPUnit_Framework_TestCase;

class SupplierOfferTest extends PHPUnit_Framework_TestCase
{
    public function testToJson()
    {
        $offer = new SupplierOffer(
            'abc-123',
            '1234',
            new DateTimeImmutable('2017-01-01'),
            new DateTimeImmutable('2017-02-01'),
            [
                new SupplierPrice(1, 4, 'EUR', '42.68'),
                new SupplierPrice(4, null, 'EUR', '32'),
            ]
        );

        $expected = <<<'JSON'
{
    "sku": "abc-123",
    "supplierId": "1234",
    "startDate": "2017-01-01T00:00:00+00:00",
    "endDate": "2017-02-01T00:00:00+00:00",
    "prices": [
        {
            "from": 1,
            "to": 4,
            "currency": "EUR",
            "value": "42.68"
        },
        {
            "from": 4,
            "to": null,
            "currency": "EUR",
            "value": "32"
        }
    ]
}
JSON;

        $this->assertEquals($expected, json_encode($offer, JSON_PRETTY_PRINT));

        $expectedEntity = new Entity(
            new EntityId('supplier.offer', 'abc-123|1234|2017-01-01T00:00:00+00:00'),
            json_encode($offer)
        );
        $this->assertEquals($expectedEntity, $offer->asNervusEntity());
    }
}