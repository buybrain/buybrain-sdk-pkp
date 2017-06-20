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

    /**
     * @param string $sku
     * @param DateTimeInterface $date
     * @param int $stock
     */
    public function __construct($sku, DateTimeInterface $date, $stock)
    {
        $this->sku = (string)$sku;
        $this->date = $date;
        $this->stock = (int)$stock;
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

        return sprintf(
            '%s|%s',
            $this->sku,
            DateTimes::format($this->date)
        );
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
     * @return array
     */
    public function jsonSerialize()
    {
        $data = [
            'sku' => $this->sku,
            'date' => DateTimes::format($this->date),
            'stock' => $this->stock,
        ];
        if ($this->id !== null) {
            $data['id'] = $this->id;
        }
        return $data;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return self::ENTITY_TYPE;
    }
}
