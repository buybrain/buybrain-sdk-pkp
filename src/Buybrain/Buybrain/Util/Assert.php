<?php
namespace Buybrain\Buybrain\Util;

use Buybrain\Buybrain\Exception\InvalidArgumentException;
use DateTimeInterface;

class Assert
{
    /**
     * Assert that every instance in the $instances array is an instance of the given type
     *
     * @param array $instances
     * @param string $expectedType
     * @throws InvalidArgumentException
     */
    public static function instancesOf(array $instances, $expectedType)
    {
        foreach ($instances as $instance) {
            if (!$instance instanceof $expectedType) {
                throw new InvalidArgumentException(
                    'Failed to assert that all elements are instances of %s (got %s)',
                    $expectedType,
                    get_class($instance)
                );
            }
        }
    }

    /**
     * Assert that the given instance is either null or an instance of the given type
     *
     * @param mixed $instance
     * @param string $expectedType
     * @throws InvalidArgumentException
     */
    public static function instanceOfOrNull($instance, $expectedType)
    {
        if ($instance !== null && !$instance instanceof $expectedType) {
            throw new InvalidArgumentException(
                'Failed to assert that the element is null or an instance of %s (got %s)',
                $expectedType,
                get_class($instance)
            );
        }
    }

    /**
     * Assert that the first parameter is less than the second parameter using the < operator
     *
     * @param mixed $left
     * @param mixed $right
     * @param string|null $message optional extra description of what went wrong in case the assertion fails
     * @throws InvalidArgumentException
     */
    public static function lessThan($left, $right, $message = null)
    {
        if (!($left < $right)) {
            self::raise($message, '%s is less than %s', $left, $right);
        }
    }

    /**
     * Assert that the first parameter is greater than the second parameter using the > operator
     *
     * @param mixed $left
     * @param mixed $right
     * @param string|null $message optional extra description of what went wrong in case the assertion fails
     * @throws InvalidArgumentException
     */
    public static function greaterThan($left, $right, $message = null)
    {
        if (!($left > $right)) {
            self::raise($message, '%s is greater than %s', $left, $right);
        }
    }

    /**
     * Assert that the first parameter is greater than or equal to the second parameter using the >= operator
     *
     * @param mixed $left
     * @param mixed $right
     * @param string|null $message optional extra description of what went wrong in case the assertion fails
     * @throws InvalidArgumentException
     */
    public static function greaterThanOrEqual($left, $right, $message = null)
    {
        if (!($left >= $right)) {
            self::raise($message, '%s is greater than or equal to %s', $left, $right);
        }
    }

    /**
     * @param $message
     * @param $description
     * @throws InvalidArgumentException
     */
    private static function raise($message, $description)
    {
        $args = func_get_args();
        $templateArgs = array_map(function ($arg) {
            return self::stringify($arg);
        }, array_slice($args, 2));

        $prefix = $message === null ? 'Failed to assert that' : $message . ': failed to assert that';
        $template = $prefix . ' ' . $description;

        throw new InvalidArgumentException($template, $templateArgs);
    }

    private static function stringify($obj)
    {
        if (is_string($obj) || is_bool($obj) || is_int($obj) || is_float($obj) || $obj === null) {
            return (string)$obj;
        }
        if ($obj instanceof DateTimeInterface) {
            return DateTimes::format($obj);
        }
        if (is_object($obj)) {
            return sprintf('Object of class %s', get_class($obj));
        }
        return sprintf('Value of type %s', get_type($obj));
    }
}
