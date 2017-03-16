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
    /** @var float[] */
    private $certainties;

    /**
     * @param DateTimeInterface $fromDate start of the period
     * @param DateTimeInterface $toDate end of the period, exclusive
     * @param SalesForecastQuantityProbability[] $probabilities of the sold quantity falling in certain quantity ranges
     * @param float[] $certainties cumulative certainties that up to a quantity gets sold before the end of this period
     */
    public function __construct(
        DateTimeInterface $fromDate,
        DateTimeInterface $toDate,
        array $probabilities,
        array $certainties
    ) {
        $this->fromDate = $fromDate;
        $this->toDate = $toDate;
        $this->probabilities = $probabilities;
        $this->certainties = $certainties;
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
     * Get the map of the certainties that no more than a specific quantity is sold before the end of the period.
     * For example, a key of "2" with a value of 0.8125 means that there is a 81.25% chance that no more than 2 items
     * get sold before the end of the current period, including the amounts sold in previous periods.
     *
     * @return float[] certainties between 0.0 and 1.0 indexed by integer quantities
     */
    public function getCertainties()
    {
        return $this->certainties;
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
            'certainties' => (object)$this->certainties
        ];
    }

    /**
     * Create a SalesForecastPeriod instance from parsed JSON
     *
     * @param array $json
     * @return SalesForecastPeriod
     */
    public static function fromJson(array $json)
    {
        return new self(
            DateTimes::parse($json['from']),
            DateTimes::parse($json['to']),
            array_map([SalesForecastQuantityProbability::class, 'fromJson'], $json['probabilities']),
            $json['certainties']
        );
    }
}
