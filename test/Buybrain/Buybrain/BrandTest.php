<?php
namespace Buybrain\Buybrain;

use Buybrain\Nervus\Entity;
use Buybrain\Nervus\EntityId;
use PHPUnit_Framework_TestCase;

class BrandTest extends PHPUnit_Framework_TestCase
{
    public function testToJson()
    {
        $brand = new Brand(
            '42',
            'A.C.M.E.'
        );

        $expected = <<<'JSON'
{
    "id": "42",
    "name": "A.C.M.E."
}
JSON;

        $this->assertEquals($expected, json_encode($brand, JSON_PRETTY_PRINT));

        $expectedEntity = new Entity(new EntityId('brand', '42'), json_encode($brand));
        $this->assertEquals($expectedEntity, $brand->asNervusEntity());
    }
}