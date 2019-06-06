<?php
namespace Buybrain\Buybrain\Util;

use Buybrain\Buybrain\Exception\InvalidArgumentException;
use DateTimeInterface;

/**
 * Representation of a local date without time and time zone information
 */
class LocalDate
{
    /** @var int */
    private $year;
    /** @var int */
    private $month;
    /** @var int */
    private $day;

    /**
     * @param int $year
     * @param int $month
     * @param int $day
     * @throws InvalidArgumentException if the date is not valid
     */
    public function __construct($year, $month, $day)
    {
        $this->year = (int)$year;
        $this->month = (int)$month;
        $this->day = (int)$day;

        if (!checkdate($this->month, $this->day, $this->year)) {
            throw new InvalidArgumentException(
                'Invalid date (%d-%d-%d)',
                $this->year,
                $this->month,
                $this->day
            );
        }
    }

    /**
     * @return int
     */
    public function getYear()
    {
        return $this->year;
    }

    /**
     * @return int
     */
    public function getMonth()
    {
        return $this->month;
    }

    /**
     * @return int
     */
    public function getDay()
    {
        return $this->day;
    }

    /**
     * Format this date in ISO date format
     * 
     * @return string
     */
    public function format()
    {
        return sprintf('%d-%02d-%02d', $this->getYear(), $this->getMonth(), $this->getDay());
    }

    /**
     * Parse an ISO date string (YYYY-mm-dd format)
     * 
     * @param string $formatted
     * @return LocalDate
     * @throws InvalidArgumentException if the input is not valid
     */
    public static function parse($formatted)
    {
        if (preg_match(
            '~^(\d+)-(\d{2})-(\d{2})$~',
            (string)$formatted,
            $matches
        )) {
            return new self(
                $matches[1],
                ltrim($matches[2], '0'),
                ltrim($matches[3], '0')
            );
        }
        throw new InvalidArgumentException('Invalid date (%s)', (string)$formatted);
    }

    /**
     * Create a LocalDate from the raw date part of a DateTimeInterface
     * 
     * @param DateTimeInterface $dateTime
     * @return LocalDate
     * @throws InvalidArgumentException
     */
    public static function fromDateTime(DateTimeInterface $dateTime)
    {
        return new self(
            $dateTime->format('Y'),
            $dateTime->format('m'),
            $dateTime->format('d')
        );
    }
}
