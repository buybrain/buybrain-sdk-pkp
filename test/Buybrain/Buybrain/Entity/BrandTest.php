<?php
namespace Buybrain\Buybrain\Entity;

use Buybrain\Nervus\Entity;
use PHPUnit\Framework\TestCase;

class BrandTest extends TestCase
{
    public function testToAndFromJson()
    {
        $brand = new Brand(
            '42',
            'A.C.M.E.'
        );

        $expectedJson = <<<'JSON'
{
    "id": "42",
    "name": "A.C.M.E."
}
JSON;

        $this->assertEquals($expectedJson, json_encode($brand, JSON_PRETTY_PRINT));

        $expectedEntity = new Entity(Brand::id(42), json_encode($brand));
        $this->assertEquals($expectedEntity, $brand->asNervusEntity());

        $this->assertEquals($brand, Brand::fromJson(json_decode($expectedJson, true)));
    }

    public function testEntityIDs()
    {
        $expected = [
            Brand::id(1),
            Brand::id(2),
            Brand::id(3),
        ];

        $this->assertEquals($expected, Brand::ids(1, 2, 3));
        $this->assertEquals($expected, Brand::ids([1, 2, 3]));
    }
}
