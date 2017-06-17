<?php
namespace Buybrain\Buybrain\Api;

use Buybrain\Buybrain\Api\Message\AdviseResponse;
use Buybrain\Buybrain\Api\Message\AdviseResponseSku;
use PHPUnit_Framework_TestCase;

class AdviseResponseTest extends PHPUnit_Framework_TestCase
{
    public function testJsonSerde()
    {
        $SUT = new AdviseResponse(
            '00000000-0000-0000-0000-000000000000',
            AdviseResponse::STATUS_COMPLETE,
            1.0,
            [
                new AdviseResponseSku(
                    'abc-123',
                    [
                        0 => 0.5,
                        1 => 0.25,
                        2 => 0.25,
                    ]
                )
            ]
        );

        $json = json_encode($SUT, JSON_PRETTY_PRINT);

        $expectedJson = <<<'JSON'
{
    "adviseId": "00000000-0000-0000-0000-000000000000",
    "status": "complete",
    "progress": 1,
    "skus": [
        {
            "sku": "abc-123",
            "certainties": {
                "0": 0.5,
                "1": 0.25,
                "2": 0.25
            }
        }
    ]
}
JSON;

        $this->assertEquals($expectedJson, $json);

        $restored = AdviseResponse::fromJson(json_decode($json, true));

        $this->assertEquals($SUT, $restored);
    }
}
