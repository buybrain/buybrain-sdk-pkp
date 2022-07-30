<?php
namespace Buybrain\Buybrain\Entity;

use Buybrain\Buybrain\Util\DateTimes;
use DateTimeInterface;

/**
 * Measurement of the total physical stock for a single SKU at a specific point in time
 */
class Stock implements BuybrainEntity
{
    const ENTITY_TYPE = 'article.stock';

    use AsNervusEntityTrait;
    use EntityIdFactoryTrait;

    /** @var string|null */
    private $id;
    /** @var string */
    private $sku;
    /** @var DateTimeInterface */
    private $date;
    /** @var int */
    private $stock;
    /** @var Money|null */
    private $averageValue;

    /**
     * @param string $sku the unique identifier of the article
     * @param DateTimeInterface $date
     * @param int $stock the total quantity of stock at the given date
     * @param Money|null $averageValue the average value of a single stock item at the given date
     */
    public function __construct($sku, DateTimeInterface $date, $stock, Money $averageValue = null)
    {
        $this->sku = (string)$sku;
        $this->date = $date;
        $this->stock = (int)$stock;
        $this->averageValue = $averageValue;
    }

    /**
     * Set a custom ID for this stock entity
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
        return self::getAutoId($this->sku, $this->date);
    }

    /**
     * Generate an ID for this entity based on the SKU and the date
     *
     * @param string $sku
     * @param DateTimeInterface $date
     * @return string
     */
    public static function getAutoId($sku, DateTimeInterface $date)
    {
        return sprintf(
            '%s|%s',
            $sku,
            DateTimes::format($date)
        );
    }

    /**
     * Parse an auto generated ID back into the original components (SKU and date)
     *
     * @param string $autoId
     * @return array of [string, DateTimeInterface]
     */
    public static function parseAutoId($autoId)
    {
        list($sku, $date) = explode('|', $autoId);
        return [$sku, DateTimes::parse($date)];
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
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @return int
     */
    public function getStock()
    {
        return $this->stock;
    }

    /**
     * @return Money|null
     */
    public function getAverageValue()
    {
        return $this->averageValue;
    }

    public function jsonSerialize(): array
    {
        $data = [
            'sku' => $this->sku,
            'date' => DateTimes::format($this->date),
            'stock' => $this->stock,
        ];
        if ($this->averageValue !== null) {
            $data['avgValue'] = $this->averageValue;
        }
        if ($this->id !== null) {
            $data['id'] = $this->id;
        }
        return $data;
    }

    /**
     * @param array $json
     * @return Stock
     */
    public static function fromJson(array $json)
    {
        if (isset($json['avgValue'])) {
            $avgValue = Money::fromJson($json['avgValue']);
        } else {
            $avgValue = null;
        }
        $stock = new self(
            $json['sku'],
            DateTimes::parse($json['date']),
            $json['stock'],
            $avgValue
        );
        if (isset($json['id'])) {
            $stock->setId($json['id']);
        }
        return $stock;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return self::ENTITY_TYPE;
    }
}
