<?php
namespace Buybrain\Buybrain;

use Buybrain\Buybrain\Util\DateTimes;
use DateTimeInterface;

/**
 * Representation of a period of time in which an article was available for selling. This might mean it was orderable
 * on a web shop or physically available on a store shelf.
 */
class ArticleSellablePeriod implements BuybrainEntity
{
    const ENTITY_TYPE = 'article.sellablePeriod';

    use AsNervusEntityTrait;
    use EntityIdFactoryTrait;

    /** @var string|null */
    private $id;
    /** @var string */
    private $sku;
    /** @var string */
    private $channel;
    /** @var DateTimeInterface */
    private $startDate;
    /** @var DateTimeInterface|null */
    private $endDate;

    /**
     * @param string $sku
     * @param DateTimeInterface $startDate
     * @param DateTimeInterface|null $endDate optional end date, set to null if this is the current period
     * @param string $channel the channel through which the article was sellable
     */
    public function __construct($sku, DateTimeInterface $startDate, DateTimeInterface $endDate = null, $channel)
    {
        $this->sku = (string)$sku;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->channel = (string)$channel;
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
     * Set a custom ID for this period
     *
     * @param string $id
     * @return $this
     */
    public function setId($id)
    {
        $this->id = (string)$id;
        return $this;
    }

    /**
     * @return string
     */
    public function getId()
    {
        if ($this->id !== null) {
            return $this->id;
        }

        return sprintf(
            '%s|%s|%s',
            $this->sku,
            $this->channel === null ? '' : $this->channel,
            DateTimes::format($this->startDate)
        );
    }

    /**
     * @return array
     */
    public function jsonSerialize()
    {
        $data = [
            'sku' => $this->sku,
            'startDate' => DateTimes::format($this->startDate),
            'endDate' => DateTimes::format($this->endDate),
            'channel' => $this->channel,
        ];
        if ($this->id !== null) {
            $data['id'] = $this->id;
        }
        return $data;
    }
}
