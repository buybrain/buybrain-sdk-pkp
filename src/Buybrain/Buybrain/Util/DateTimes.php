<?php
namespace Buybrain\Buybrain\Util;

use DateTimeInterface;

class DateTimes
{
    /**
     * Format an optional date, returning null if the input is null
     *
     * @param DateTimeInterface|null $input
     * @param string $format
     * @return null|string
     */
    public static function format(DateTimeInterface $input = null, $format)
    {
        if ($input === null) {
            return null;
        }
        return $input->format($format);
    }
}