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
            return array_map(function ($val) {
                return (string)$val;
            }, $input);
        }
        return (string)$input;
    }
}