<?php
namespace Buybrain\Buybrain\Util;

use Buybrain\Buybrain\Entity\ArticleType;
use Buybrain\Buybrain\Entity\Brand;
use DateTimeImmutable;
use PHPUnit\Framework\TestCase;

class AssertTest extends TestCase
{
    /**
     * @doesNotPerformAssertions
     */
    public function testAssertInstancesOfWithValidData()
    {
        Assert::instancesOf(
            [new Brand('1', 'a'), new Brand('2', 'b')],
            Brand::class
        );
    }

    public function testAssertInstancesOfWithInvalidData()
    {
        $this->expectException('Buybrain\Buybrain\Exception\InvalidArgumentException');
        $this->expectExceptionMessage(
            'Failed to assert that all elements are instances of Buybrain\Buybrain\Entity\ArticleType ' .
            '(got Buybrain\Buybrain\Entity\Brand)'
        );

        Assert::instancesOf(
            [new ArticleType('1', 'a'), new Brand('2', 'b')],
            ArticleType::class
        );
    }

    /**
     * @doesNotPerformAssertions
     */
    public function testAssertInstanceOfOrNullWithValidData()
    {
        Assert::instanceOfOrNull(new Brand('1', 'a'), Brand::class);
        Assert::instanceOfOrNull(null, Brand::class);
    }

    public function testAssertInstanceOfOrNullWithInvalidData()
    {
        $this->expectException('Buybrain\Buybrain\Exception\InvalidArgumentException');
        $this->expectExceptionMessage(
            'Failed to assert that the element is null or an instance of Buybrain\Buybrain\Entity\Brand ' .
            '(got Buybrain\Buybrain\Entity\ArticleType)'
        );

        Assert::instanceOfOrNull(new ArticleType('1', 'a'), Brand::class);
    }

    /**
     * @doesNotPerformAssertions
     */
    public function testAssertLessThanWithValidData()
    {
        Assert::lessThan(1, 2);
        Assert::lessThan('a', 'b');
        Assert::lessThan(new DateTimeImmutable('2017-01-01'), new DateTimeImmutable('2018-01-01'));
    }

    public function testAssertLessThanWithInvalidData()
    {
        $this->expectException('Buybrain\Buybrain\Exception\InvalidArgumentException');
        $this->expectExceptionMessage('Failed to assert that 2 is less than 1');

        Assert::lessThan(2, 1);
    }

    public function testAssertLessThanWithExtraMessasge()
    {
        $this->expectException('Buybrain\Buybrain\Exception\InvalidArgumentException');
        $this->expectExceptionMessage('Custom error: failed to assert that 2 is less than 1');

        Assert::lessThan(2, 1, 'Custom error');
    }
}
