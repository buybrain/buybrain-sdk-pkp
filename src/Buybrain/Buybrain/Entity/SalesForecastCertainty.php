<?php
namespace Buybrain\Buybrain\Entity;

use JsonSerializable;

/**
 * This class defines a range of forecast periods and a distribution of cumulative certainties that no more than
 * specific quantities get sold in that range.
 *
 * @see SalesForecast
 * @see SalesForecastPeriod
 */
class SalesForecastCertainty implements JsonSerializable
{
    /** @var int */
    private $from;
    /** @var int */
    private $periods;
    /** @var float[] */
    private $perQuantity;

    /**
     * @param int $from index of the first period from the parent forecast, start of the period range
     * @param int $periods number of periods in this certainty range
     * @param float[] $perQuantity cumulative certainties that up to a quantity gets sold in this period range
     */
    public function __construct($from, $periods, array $perQuantity)
    {
        $this->from = $from;
        $this->periods = $periods;
        $this->perQuantity = $perQuantity;
    }

    /**
     * @return int
     */
    public function getFrom()
    {
        return $this->from;
    }

    /**
     * @return int
     */
    public function getPeriods()
    {
        return $this->periods;
    }

    /**
     * Get the map of the certainties that no more than a specific quantity is sold before the end of the period.
     * For example, a key of "2" with a value of 0.8125 means that there is a 81.25% chance that no more than 2 items
     * get sold in total in this period range.
     *
     * @return float[] certainties between 0.0 and 1.0 indexed by integer quantities
     */
    public function getPerQuantity()
    {
        return $this->perQuantity;
    }

    /**
     * @return array
     */
    public function jsonSerialize()
    {
        return [
            'from' => $this->from,
            'periods' => $this->periods,
            'perQuantity' => (object)$this->perQuantity
        ];
    }

    /**
     * Create a SalesForecastCertainty instance from parsed JSON
     *
     * @param array $json
     * @return SalesForecastCertainty
     */
    public static function fromJson(array $json)
    {
        return new self(
            $json['from'],
            $json['periods'],
            $json['perQuantity']
        );
    }
}
