<?php
namespace Buybrain\Buybrain\Util;

use InvalidArgumentException;

class Assert
{
    /**
     * Assert that every instance in the $instances array is an instance of a type
     *
     * @param array $instances
     * @param string $expectedType
     */
    public static function instancesOf(array $instances, $expectedType)
    {
        foreach ($instances as $instance) {
            if (!$instance instanceof $expectedType) {
                throw new InvalidArgumentException(sprintf(
                    'Failed to assert all elements are instances of %s (got %s)',
                    $expectedType,
                    get_class($instance)
                ));
            }
        }
    }
}
