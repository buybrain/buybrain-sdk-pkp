<?php
namespace Buybrain\Buybrain\Util;

use DateTime;
use DateTimeInterface;

class DateTimes
{
    /**
     * Format an optional date in ISO date-time format, returning null if the input is null
     *
     * @param DateTimeInterface|null $input
     * @return null|string
     */
    public static function format(DateTimeInterface $input = null)
    {
        if ($input === null) {
            return null;
        }
        return $input->format(DateTime::W3C);
    }
}
