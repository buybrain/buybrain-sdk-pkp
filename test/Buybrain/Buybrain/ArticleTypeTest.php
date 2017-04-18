<?php
namespace Buybrain\Buybrain;

use Buybrain\Nervus\Entity;
use Buybrain\Nervus\EntityId;
use PHPUnit_Framework_TestCase;

class ArticleTypeTest extends PHPUnit_Framework_TestCase
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

        $expectedEntity = new Entity(new EntityId('article.type', '42'), json_encode($type));
        $this->assertEquals($expectedEntity, $type->asNervusEntity());
    }
}