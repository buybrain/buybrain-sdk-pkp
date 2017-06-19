<?php
namespace Buybrain\Buybrain\Util;

class Cast
{
    /**
     * @param mixed $input
     * @return null|string|string[]
     */
    public static function toString($input)
    {
        if ($input === null) {
            return $input;
        }
        if (is_array($input)) {
            return array_map([self::class, 'toString'], $input);
        }
        return (string)$input;
    }

    /**
     * @param mixed $input
     * @return null|int|int[]
     */
    public static function toInt($input)
    {
        if ($input === null) {
            return $input;
        }
        if (is_array($input)) {
            return array_map([self::class, 'toInt'], $input);
        }
        return (int)$input;
    }
}
