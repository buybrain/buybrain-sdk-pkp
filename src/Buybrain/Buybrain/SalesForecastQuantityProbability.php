<?php
namespace Buybrain\Buybrain;

/**
 * The probability that a certain quantity or quantity range of an article gets sold in a period of time
 *
 * @see SalesForecast
 * @see SalesForecastPeriod
 */
class SalesForecastQuantityProbability implements \JsonSerializable
{
    /** @var int */
    private $minQuantity;
    /** @var int */
    private $maxQuantity;
    /** @var float */
    private $probability;

    /**
     * @param int $minQuantity
     * @param int $maxQuantity
     * @param float $probability
     */
    public function __construct($minQuantity, $maxQuantity, $probability)
    {
        $this->minQuantity = $minQuantity;
        $this->maxQuantity = $maxQuantity;
        $this->probability = $probability;
    }

    /**
     * @return int
     */
    public function getMinQuantity()
    {
        return $this->minQuantity;
    }

    /**
     * @return int
     */
    public function getMaxQuantity()
    {
        return $this->maxQuantity;
    }

    /**
     * @return float
     */
    public function getProbability()
    {
        return $this->probability;
    }

    /**
     * @return array
     */
    public function jsonSerialize()
    {
        return [
            'min' => $this->minQuantity,
            'max' => $this->maxQuantity,
            'p' => $this->probability
        ];
    }
}
