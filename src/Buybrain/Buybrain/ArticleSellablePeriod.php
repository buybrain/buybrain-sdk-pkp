<?php
namespace Buybrain\Buybrain;

use Buybrain\Buybrain\Util\DateTimes;
use DateTime;
use DateTimeInterface;

/**
 * Representation of a period of time in which an article was available for selling. This might mean it was orderable
 * on a web shop or physically available on a store shelf.
 */
class ArticleSellablePeriod implements BuybrainEntity
{
    const ENTITY_TYPE = 'article.sellablePeriod';

    use AsNervusEntityTrait;

    /** @var string */
    private $sku;
    /** @var string|null */
    private $channel;
    /** @var DateTimeInterface */
    private $startDate;
    /** @var DateTimeInterface|null */
    private $endDate;

    /**
     * @param string $sku
     * @param DateTimeInterface $startDate
     * @param DateTimeInterface|null $endDate optional end date, set to null if this is the current period
     */
    public function __construct($sku, DateTimeInterface $startDate, DateTimeInterface $endDate = null)
    {
        $this->sku = (string)$sku;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    /**
     * @return string
     */
    public function getSku()
    {
        return $this->sku;
    }

    /**
     * @return null|string
     */
    public function getChannel()
    {
        return $this->channel;
    }

    /**
     * Specify the channel through which the article was sellable
     *
     * @param string $channel
     * @return $this
     */
    public function setChannel($channel)
    {
        $this->channel = $channel;
        return $this;
    }

    /**
     * @return DateTimeInterface
     */
    public function getStartDate()
    {
        return $this->startDate;
    }

    /**
     * @return DateTimeInterface|null
     */
    public function getEndDate()
    {
        return $this->endDate;
    }

    /**
     * @return string
     */
    public function getId()
    {
        return sprintf(
            '%s|%s',
            $this->sku,
            $this->startDate->format(DateTime::W3C)
        );
    }

    /**
     * @return array
     */
    public function jsonSerialize()
    {
        $data = [
            'sku' => $this->sku,
            'startDate' => $this->startDate->format(DateTime::W3C),
            'endDate' => DateTimes::format($this->endDate, DateTime::W3C),
        ];
        if ($this->channel !== null) {
            $data['channel'] = $this->channel;
        }
        return $data;
    }
}