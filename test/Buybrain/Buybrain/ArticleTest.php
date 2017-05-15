<?php
namespace Buybrain\Buybrain;

use Buybrain\Nervus\Entity;
use Buybrain\Nervus\EntityId;
use PHPUnit_Framework_TestCase;

class ArticleTest extends PHPUnit_Framework_TestCase
{
    public function testToJson()
    {
        $article = new Article(
            'abc-123',
            'Rubber ducky',
            ['123', '456'],
            ['789']
        );

        $expected = <<<'JSON'
{
    "sku": "abc-123",
    "name": "Rubber ducky",
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