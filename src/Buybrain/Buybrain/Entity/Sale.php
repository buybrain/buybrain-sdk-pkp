<?php
namespace Buybrain\Buybrain\Entity;

use Buybrain\Buybrain\Util\DateTimes;
use DateTimeInterface;
use JsonSerializable;

/**
 * Represents the sale of a particular SKU at a particular date.
 * Can represent a cancellation/return by using a negative quantity.
 *
 * @see CustomerOrder
 */
class Sale implements JsonSerializable
{
    /** @var string */
    private $sku;
    /** @var DateTimeInterface */
    private $date;
    /** @var int */
    private $quantity;

    /**
     * @param string $sku
     * @param DateTimeInterface $date
     * @param int $quantity
     */
    public function __construct($sku, DateTimeInterface $date, $quantity)
    {
        $this->sku = (string)$sku;
        $this->date = $date;
        $this->quantity = (int)$quantity;
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
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * @return array
     */
    function jsonSerialize()
    {
        return [
            'sku' => $this->sku,
            'date' => DateTimes::format($this->date),
            'quantity' => $this->quantity
        ];
    }
}
