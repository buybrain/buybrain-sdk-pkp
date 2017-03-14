<?php
namespace Buybrain\Buybrain\Util;

use DateTime;
use DateTimeImmutable;
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

    /**
     * Parse an ISO formatted date-time, returning null if the input is null
     *
     * @param string|null $input
     * @return DateTimeImmutable|null
     */
    public static function parse($input = null)
    {
        if ($input === null) {
            return null;
        }
        return new DateTimeImmutable($input);
    }
}
