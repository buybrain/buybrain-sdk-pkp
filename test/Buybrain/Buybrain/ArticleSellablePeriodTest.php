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
            new DateTimeImmutable('2017-01-01 00:00'),
            new DateTimeImmutable('2017-01-05 00:00')
        );

        $expected = <<<'JSON'
{
    "sku": "abc-123",
    "startDate": "2017-01-01T00:00:00+00:00",
    "endDate": "2017-01-05T00:00:00+00:00"
}
JSON;

        $this->assertEquals($expected, json_encode($period, JSON_PRETTY_PRINT));

        $expectedEntity = new Entity(
            new EntityId('article.sellablePeriod', 'abc-123|2017-01-01T00:00:00+00:00'),
            json_encode($period)
        );
        $this->assertEquals($expectedEntity, $period->asNervusEntity());
    }

    public function testToJsonWithChannel()
    {
        $period = new ArticleSellablePeriod(
            'abc-123',
            new DateTimeImmutable('2017-01-01 00:00'),
            new DateTimeImmutable('2017-01-05 00:00')
        );
        $period = $period->setChannel('webshop/nl');

        $expected = <<<'JSON'
{
    "sku": "abc-123",
    "startDate": "2017-01-01T00:00:00+00:00",
    "endDate": "2017-01-05T00:00:00+00:00",
    "channel": "webshop\/nl"
}
JSON;

        $this->assertEquals($expected, json_encode($period, JSON_PRETTY_PRINT));

        $expectedEntity = new Entity(
            new EntityId('article.sellablePeriod', 'abc-123|2017-01-01T00:00:00+00:00'),
            json_encode($period)
        );
        $this->assertEquals($expectedEntity, $period->asNervusEntity());
    }
}