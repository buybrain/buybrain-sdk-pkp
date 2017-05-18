<?php
namespace Buybrain\Buybrain;

use Buybrain\Nervus\Entity;
use Buybrain\Nervus\EntityId;
use DateTimeImmutable;
use PHPUnit_Framework_TestCase;

class ArticleSellablePeriodTest extends PHPUnit_Framework_TestCase
{
    public function testToJson()
    {
        $period = new ArticleSellablePeriod(
            'abc-123',
            new DateTimeImmutable('2017-01-01 00:00Z'),
            new DateTimeImmutable('2017-01-05 00:00Z'),
            'shop'
        );

        $expected = <<<'JSON'
{
    "sku": "abc-123",
    "startDate": "2017-01-01T00:00:00+00:00",
    "endDate": "2017-01-05T00:00:00+00:00",
    "channel": "shop"
}
JSON;

        $this->assertEquals($expected, json_encode($period, JSON_PRETTY_PRINT));

        $expectedEntity = new Entity(
            ArticleSellablePeriod::id('abc-123|shop|2017-01-01T00:00:00+00:00'),
            json_encode($period)
        );
        $this->assertEquals($expectedEntity, $period->asNervusEntity());
    }

    public function testToEntityWithCustomId()
    {
        $period = (new ArticleSellablePeriod(
            'abc-123',
            new DateTimeImmutable('2017-01-01 00:00Z'),
            new DateTimeImmutable('2017-01-05 00:00Z'),
            'shop'
        ))->setId('987');
        
        $expectedEntity = new Entity(
            ArticleSellablePeriod::id('987'),
            json_encode($period)
        );
        $this->assertEquals($expectedEntity, $period->asNervusEntity());
    }

    public function testToJsonWithCustomID()
    {
        $period = new ArticleSellablePeriod(
            'abc-123',
            new DateTimeImmutable('2017-01-01 00:00Z'),
            new DateTimeImmutable('2017-01-05 00:00Z'),
            'shop'
        );
        $period = $period->setId(1234);

        $expected = <<<'JSON'
{
    "sku": "abc-123",
    "startDate": "2017-01-01T00:00:00+00:00",
    "endDate": "2017-01-05T00:00:00+00:00",
    "channel": "shop",
    "id": "1234"
}
JSON;

        $this->assertEquals($expected, json_encode($period, JSON_PRETTY_PRINT));

        $expectedEntity = new Entity(
            ArticleSellablePeriod::id('1234'),
            json_encode($period)
        );
        $this->assertEquals($expectedEntity, $period->asNervusEntity());
    }
}
