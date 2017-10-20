<?php
namespace Buybrain\Buybrain\Entity;

use Buybrain\Nervus\Entity;
use PHPUnit\Framework\TestCase;

class ArticleTest extends TestCase
{
    public function testToJson()
    {
        $article = new Article(
            'abc-123',
            'Rubber ducky',
            ['site', 'shop', 'site'], // Stock channels should get sorted and de-duplicated
            ['123', '456'],
            ['789']
        );

        $expected = <<<'JSON'
{
    "sku": "abc-123",
    "name": "Rubber ducky",
    "stockChannels": [
        "shop",
        "site"
    ],
    "typeIds": [
        "123",
        "456"
    ],
    "brandId": [
        "789"
    ]
}
JSON;

        $this->assertEquals($expected, json_encode($article, JSON_PRETTY_PRINT));

        $expectedEntity = new Entity(Article::id('abc-123'), json_encode($article));
        $this->assertEquals($expectedEntity, $article->asNervusEntity());
    }
}
