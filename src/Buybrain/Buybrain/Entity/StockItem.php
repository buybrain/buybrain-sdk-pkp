<?php
namespace Buybrain\Buybrain\Entity;

use Buybrain\Buybrain\Util\DateTimes;
use DateTimeInterface;

/**
 * Representation of a single instance of inventory during a period of time
 */
class StockItem implements BuybrainEntity
{
    const ENTITY_TYPE = 'article.stockItem';

    use AsNervusEntityTrait;
    use EntityIdFactoryTrait;

    /** @var string */
    private $id;
    /** @var string */
    private $sku;
    /** @var DateTimeInterface */
    private $startDate;
    /** @var DateTimeInterface|null */
    private $endDate;

    /**
     * @param string $id
     * @param string $sku
     * @param DateTimeInterface $startDate
     * @param DateTimeInterface|null $endDate
     */
    public function __construct($id, $sku, DateTimeInterface $startDate, DateTimeInterface $endDate = null)
    {
        $this->id = (string)$id;
        $this->sku = (string)$sku;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getSku()
    {
        return $this->sku;
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
     * @return array
     */
    public function jsonSerialize()
    {
        return [
            'id' => $this->id,
            'sku' => $this->sku,
            'startDate' => DateTimes::format($this->startDate),
            'endDate' => DateTimes::format($this->endDate),
        ];
    }

    /**
     * @return string
     */
    public function getType()
    {
        return self::ENTITY_TYPE;
    }
}
