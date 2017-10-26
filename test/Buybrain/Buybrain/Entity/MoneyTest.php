<?php
namespace Buybrain\Buybrain\Entity;

use PHPUnit\Framework\TestCase;

class MoneyTest extends TestCase
{
    public function testJsonSerde()
    {
        $SUT = new Money('EUR', '12.34');

        $json = $SUT->jsonSerialize();

        $this->assertEquals(['currency' => 'EUR', 'value' => '12.34'], $json);

        $restored = Money::fromJson($json);

        $this->assertEquals($SUT, $restored);
    }

    public function testToString()
    {
        $this->assertEquals('GBP 10.0', new Money('GBP', '10.0'));
        $this->assertEquals('EUR -10', new Money('EUR', '-10'));
    }
}
