<?php
namespace Buybrain\Buybrain\Entity;

use Buybrain\Nervus\Entity;
use PHPUnit\Framework\TestCase;

class ArticleTypeTest extends TestCase
{
    public function testToAndFromJson()
    {
        $type = new ArticleType(
            '42',
            'Sportswear'
        );

        $expectedJson = <<<'JSON'
{
    "id": "42",
    "name": "Sportswear"
}
JSON;

        $this->assertEquals($expectedJson, json_encode($type, JSON_PRETTY_PRINT));

        $expectedEntity = new Entity(ArticleType::id(42), json_encode($type));
        $this->assertEquals($expectedEntity, $type->asNervusEntity());

        $this->assertEquals($type, ArticleType::fromJson(json_decode($expectedJson, true)));
    }
}
