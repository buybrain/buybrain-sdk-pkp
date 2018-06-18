<?php
namespace Buybrain\Buybrain\Entity;

use Buybrain\Buybrain\Entity\SupplierStock\ExactSupplierStock;
use Buybrain\Buybrain\Entity\SupplierStock\SupplierStockIndicator;
use Buybrain\Nervus\Entity;
use DateTimeImmutable;
use PHPUnit\Framework\TestCase;

class SupplierArticleTest extends TestCase
{
    public function testToAndFromJsonWithExactStockAndNoAvailabilityDate()
    {
        $article = new SupplierArticle(
            '234',
            'abc-123',
            'qux-3',
            new ExactSupplierStock(42)
        );

        $expectedJson = <<<'JSON'
{
    "supplierId": "234",
    "sku": "abc-123",
    "supplierRef": "qux-3",
    "stock": {
        "type": "exact",
        "quantity": 42
    },
    "orderQuantity": 1,
    "moq": 1
}
JSON;

        $this->assertEquals($expectedJson, json_encode($article, JSON_PRETTY_PRINT));

        $expectedEntity = new Entity(
            SupplierArticle::id('234|abc-123'),
            json_encode($article)
        );
        $this->assertEquals($expectedEntity, $article->asNervusEntity());

        $this->assertEquals($article, SupplierArticle::fromJson(json_decode($expectedJson, true)));
    }

    public function testToAndFromJsonWithStockIndicatorAndOptionalFields()
    {
        $article = (new SupplierArticle(
            '234',
            'abc-123',
            'qux-3',
            new SupplierStockIndicator(SupplierStockIndicator::HIGH)
        ))
            ->setId('123')
            ->setOrderQuantity(2)
            ->setMinimumOrderQuantity(6)
            ->setLastStockCheck(new DateTimeImmutable('2018-02-01T00:00:00Z'))
            ->setAvailableFromDate(new DateTimeImmutable('2018-01-01T00:00:00Z'));

        $expectedJson = <<<'JSON'
{
    "supplierId": "234",
    "sku": "abc-123",
    "supplierRef": "qux-3",
    "stock": {
        "type": "indicator",
        "indicator": "high"
    },
    "orderQuantity": 2,
    "moq": 6,
    "lastStockCheck": "2018-02-01T00:00:00+00:00",
    "availableFromDate": "2018-01-01T00:00:00+00:00",
    "id": "123"
}
JSON;

        $this->assertEquals($expectedJson, json_encode($article, JSON_PRETTY_PRINT));

        $this->assertEquals($article, SupplierArticle::fromJson(json_decode($expectedJson, true)));
    }
}
