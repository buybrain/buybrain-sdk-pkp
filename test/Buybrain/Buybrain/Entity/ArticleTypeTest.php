<?php
namespace Buybrain\Buybrain\Entity;

use Buybrain\Nervus\Entity;
use PHPUnit\Framework\TestCase;

class ArticleTypeTest extends TestCase
{
    public function testToJson()
    {
        $type = new ArticleType(
            '42',
            'Sportswear'
        );

        $expected = <<<'JSON'
{
    "id": "42",
    "name": "Sportswear"
}
JSON;

        $this->assertEquals($expected, json_encode($type, JSON_PRETTY_PRINT));

        $expectedEntity = new Entity(ArticleType::id(42), json_encode($type));
        $this->assertEquals($expectedEntity, $type->asNervusEntity());
    }
}
