<?php
namespace Buybrain\Buybrain\Entity\SupplierStock;

use DateTimeImmutable;
use PHPUnit\Framework\TestCase;

class StockCheckRequestTest extends TestCase
{
    public function testToAndFromJson()
    {
        $request = new StockCheckRequest(
            '00000000-0000-0000-0000-111111111111',
            '1234',
            ['abc-123', 'def-456'],
            new DateTimeImmutable('2018-01-01T00:00:00Z')
        );

        $json = <<<'JSON'
{
    "id": "00000000-0000-0000-0000-111111111111",
    "supplierId": "1234",
    "skus": [
        "abc-123",
        "def-456"
    ],
    "createDate": "2018-01-01T00:00:00+00:00"
}
JSON;

        $this->assertEquals($json, json_encode($request, JSON_PRETTY_PRINT));
        $this->assertEquals($request, StockCheckRequest::fromJson(json_decode($json, true)));
    }
}
