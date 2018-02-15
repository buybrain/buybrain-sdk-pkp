<?php
namespace Buybrain\Buybrain\Entity;

use Buybrain\Nervus\Entity;
use DateTimeImmutable;
use PHPUnit\Framework\TestCase;

class SupplierOfferTest extends TestCase
{
    public function testToJson()
    {
        $offer = new SupplierOffer(
            'abc-123',
            '1234',
            new DateTimeImmutable('2017-01-01Z'),
            new DateTimeImmutable('2017-02-01Z'),
            [
                new SupplierPrice(1, 4, new Money('EUR', '42.68')),
                new SupplierPrice(4, null, new Money('EUR', '32')),
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
            SupplierOffer::id('abc-123|1234|2017-01-01T00:00:00+00:00'),
            json_encode($offer)
        );
        $this->assertEquals($expectedEntity, $offer->asNervusEntity());
    }

    public function testToEntityWithCustomId()
    {
        $offer = (new SupplierOffer(
            'abc-123',
            '1234',
            new DateTimeImmutable('2017-01-01Z'),
            new DateTimeImmutable('2017-02-01Z'),
            [
                new SupplierPrice(1, 4, new Money('EUR', '42.68')),
                new SupplierPrice(4, null, new Money('EUR', '32')),
            ]
        ))->setId('987');

        $expectedEntity = new Entity(
            SupplierOffer::id(987),
            json_encode($offer)
        );
        $this->assertEquals($expectedEntity, $offer->asNervusEntity());
    }

    public function testParsingAutoID()
    {
        $sku = 'abc-123';
        $supplier = '999';
        $startDate = new DateTimeImmutable('2017-01-01');

        $id = SupplierOffer::getAutoId($sku, $supplier, $startDate);

        list($parsedSKU, $parsedSupplier, $parsedStartDate) = SupplierOffer::parseAutoId($id);

        $this->assertEquals($sku, $parsedSKU);
        $this->assertEquals($supplier, $parsedSupplier);
        $this->assertEquals($startDate, $parsedStartDate);
    }

    public function testItValidatesEndDate()
    {
        $this->expectException('Buybrain\Buybrain\Exception\InvalidArgumentException');
        $this->expectExceptionMessage(
            'Failed to assert that 2018-02-01T00:00:00+01:00 is less than 2018-01-01T00:00:00+01:00'
        );

        new SupplierOffer(
            '123',
            '987',
            new DateTimeImmutable('2018-02-01'),
            new DateTimeImmutable('2018-01-01'),
            []
        );
    }

    public function testItValidatesPrices()
    {
        $this->expectException('Buybrain\Buybrain\Exception\InvalidArgumentException');
        $this->expectExceptionMessage('Failed to assert that 0 is greater than 0');

        new SupplierOffer(
            '123',
            '987',
            new DateTimeImmutable('2018-01-01'),
            null,
            [new SupplierPrice(0, null, new Money('EUR', 0.0))]
        );
    }
}
