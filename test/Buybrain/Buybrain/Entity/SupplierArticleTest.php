<?php
namespace Buybrain\Buybrain\Entity;

use Buybrain\Buybrain\Entity\SupplierStock\ExactSupplierStock;
use Buybrain\Buybrain\Entity\SupplierStock\SupplierStockIndicator;
use Buybrain\Nervus\Entity;
use DateTimeImmutable;
use PHPUnit\Framework\TestCase;

class SupplierArticleTest extends TestCase
{
    public function testToJsonWithExactStockAndNoAvailabilityDate()
    {
        $article = new SupplierArticle(
            '234',
            'abc-123',
            new ExactSupplierStock(42)
        );

        $expected = <<<'JSON'
{
    "supplierId": "234",
    "sku": "abc-123",
    "stock": {
        "type": "exact",
        "quantity": 42
    },
    "orderQuantity": 1,
    "moq": 1
}
JSON;

        $this->assertEquals($expected, json_encode($article, JSON_PRETTY_PRINT));

        $expectedEntity = new Entity(
            SupplierArticle::id('234|abc-123'),
            json_encode($article)
        );
        $this->assertEquals($expectedEntity, $article->asNervusEntity());
    }

    public function testToJsonWithStockIndicatorAndAvailabilityDate()
    {
        $article = (new SupplierArticle(
            '234',
            'abc-123',
            new SupplierStockIndicator(SupplierStockIndicator::HIGH)
        ))
            ->setId('123')
            ->setOrderQuantity(2)
            ->setMinimumOrderQuantity(6)
            ->setAvailableFromDate(new DateTimeImmutable('2018-01-01T00:00:00Z'));

        $expected = <<<'JSON'
{
    "supplierId": "234",
    "sku": "abc-123",
    "stock": {
        "type": "indicator",
        "indicator": "high"
    },
    "orderQuantity": 2,
    "moq": 6,
    "availableFromDate": "2018-01-01T00:00:00+00:00",
    "id": "123"
}
JSON;

        $this->assertEquals($expected, json_encode($article, JSON_PRETTY_PRINT));
    }
}
