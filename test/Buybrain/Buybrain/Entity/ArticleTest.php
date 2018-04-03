<?php
namespace Buybrain\Buybrain\Entity;

use Buybrain\Nervus\Entity;
use PHPUnit\Framework\TestCase;

class ArticleTest extends TestCase
{
    public function testToAndFromJson()
    {
        $article = new Article(
            'abc-123',
            'Rubber ducky',
            ['site', 'shop', 'site'], // Stock channels should get sorted and de-duplicated
            ['123', '456'],
            ['789']
        );

        $json = <<<'JSON'
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
    ],
    "endOfLife": false
}
JSON;

        $this->assertEquals($json, json_encode($article, JSON_PRETTY_PRINT));
        $this->assertEquals($article, Article::fromJson(json_decode($json, true)));

        $expectedEntity = new Entity(Article::id('abc-123'), json_encode($article));
        $this->assertEquals($expectedEntity, $article->asNervusEntity());
    }
}
