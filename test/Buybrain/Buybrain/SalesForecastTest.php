<?php
namespace Buybrain\Buybrain;

use Buybrain\Nervus\Entity;
use DateTimeImmutable;
use PHPUnit_Framework_TestCase;

class SalesForecastTest extends PHPUnit_Framework_TestCase
{
    /** @var SalesForecast */
    private $forecast;

    public function setUp()
    {
        $this->forecast = new SalesForecast(
            '00000000-0000-0000-0000-000000000000',
            new DateTimeImmutable('2017-01-01Z'),
            '11111111-1111-1111-1111-111111111111',
            'abc-123',
            [
                new SalesForecastPeriod(
                    new DateTimeImmutable('2017-01-01Z'),
                    new DateTimeImmutable('2017-01-08Z'),
                    [
                        new SalesForecastQuantityProbability(0, 0, 0.50),
                        new SalesForecastQuantityProbability(1, 2, 0.50),
                    ],
                    [
                        '0' => 0.5,
                        '1' => 0.75,
                        '2' => 1.0
                    ]
                ),
                new SalesForecastPeriod(
                    new DateTimeImmutable('2017-01-08Z'),
                    new DateTimeImmutable('2017-01-15Z'),
                    [
                        new SalesForecastQuantityProbability(0, 0, 0.50),
                        new SalesForecastQuantityProbability(1, 2, 0.50),
                    ],
                    [
                        '0' => 0.25,
                        '1' => 0.5,
                        '2' => 0.8125,
                        '3' => 0.9375,
                        '4' => 1.0
                    ]
                )
            ]
        );
    }

    public function testToJson()
    {
        $expected = <<<'JSON'
{
    "id": "00000000-0000-0000-0000-000000000000",
    "createDate": "2017-01-01T00:00:00+00:00",
    "modelId": "11111111-1111-1111-1111-111111111111",
    "sku": "abc-123",
    "periods": [
        {
            "from": "2017-01-01T00:00:00+00:00",
            "to": "2017-01-08T00:00:00+00:00",
            "probabilities": [
                {
                    "min": 0,
                    "max": 0,
                    "p": 0.5
                },
                {
                    "min": 1,
                    "max": 2,
                    "p": 0.5
                }
            ],
            "certainties": {
                "0": 0.5,
                "1": 0.75,
                "2": 1
            }
        },
        {
            "from": "2017-01-08T00:00:00+00:00",
            "to": "2017-01-15T00:00:00+00:00",
            "probabilities": [
                {
                    "min": 0,
                    "max": 0,
                    "p": 0.5
                },
                {
                    "min": 1,
                    "max": 2,
                    "p": 0.5
                }
            ],
            "certainties": {
                "0": 0.25,
                "1": 0.5,
                "2": 0.8125,
                "3": 0.9375,
                "4": 1
            }
        }
    ]
}
JSON;

        $this->assertEquals($expected, json_encode($this->forecast, JSON_PRETTY_PRINT));

        $expectedEntity = new Entity(
            SalesForecast::id('00000000-0000-0000-0000-000000000000'),
            json_encode($this->forecast)
        );
        $this->assertEquals($expectedEntity, $this->forecast->asNervusEntity());
    }

    public function testFromJson()
    {
        $json = json_encode($this->forecast);

        $restored = SalesForecast::fromJson(json_decode($json, true));

        $this->assertEquals($this->forecast, $restored);
    }
}
