<?php
namespace Buybrain\Buybrain;

use Buybrain\Buybrain\Util\DateTimes;
use DateTimeInterface;
use JsonSerializable;

/**
 * Distribution of probabilities of selling particular quantities of articles in a certain period of time
 *
 * @see SalesForecast
 */
class SalesForecastPeriod implements JsonSerializable
{
    /** @var DateTimeInterface */
    private $fromDate;
    /** @var DateTimeInterface */
    private $toDate;
    /** @var SalesForecastQuantityProbability[] */
    private $probabilities;

    /**
     * @param DateTimeInterface $fromDate
     * @param DateTimeInterface $toDate
     * @param SalesForecastQuantityProbability[] $probabilities
     */
    public function __construct(DateTimeInterface $fromDate, DateTimeInterface $toDate, array $probabilities)
    {
        $this->fromDate = $fromDate;
        $this->toDate = $toDate;
        $this->probabilities = $probabilities;
    }

    /**
     * @return DateTimeInterface
     */
    public function getFromDate()
    {
        return $this->fromDate;
    }

    /**
     * @return DateTimeInterface
     */
    public function getToDate()
    {
        return $this->toDate;
    }

    /**
     * @return SalesForecastQuantityProbability[]
     */
    public function getProbabilities()
    {
        return $this->probabilities;
    }

    /**
     * @return array
     */
    public function jsonSerialize()
    {
        return [
            'from' => DateTimes::format($this->fromDate),
            'to' => DateTimes::format($this->toDate),
            'probabilities' => $this->probabilities,
        ];
    }
}
