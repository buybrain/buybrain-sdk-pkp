<?php
namespace Buybrain\Buybrain\Entity;

use Buybrain\Buybrain\Util\DateTimes;
use DateTimeInterface;
use JsonSerializable;

/**
 * Represents a quantity of an SKU from a purchase order that is expected to be delivered in the future. Contains
 * information useful for estimating when the delivery will take place.
 *
 * @see PurchaseOrder
 */
class ExpectedDelivery implements JsonSerializable
{
    /** @var string */
    private $sku;
    /** @var DateTimeInterface */
    private $date;
    /** @var int */
    private $quantity;
    /** @var DateTimeInterface|null */
    private $supplierAcceptDate;

    /**
     * @param string $sku the unique identifier of the article
     * @param DateTimeInterface $date the expected date the item(s) will be delivered. @deprecated, make sure to pass
     *                          $supplierAcceptDate instead.
     * @param int $quantity
     * @param DateTimeInterface|null $supplierAcceptDate the date indicating when the supplier accepts and starts
     *                               processing this order item. Usually this would be the moment the order is placed
     *                               and communicated to the supplier, but may be a later date in case of a delay.
     *                               This date is used as the starting point for delivery date estimation, with the
     *                               estimated lead time being added to it.
     */
    public function __construct($sku, DateTimeInterface $date, $quantity, DateTimeInterface $supplierAcceptDate = null)
    {
        $this->sku = (string)$sku;
        $this->date = $date;
        $this->quantity = (int)$quantity;
        $this->supplierAcceptDate = $supplierAcceptDate;
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
     * @return DateTimeInterface|null
     */
    public function getSupplierAcceptDate()
    {
        return $this->supplierAcceptDate;
    }

    public function jsonSerialize(): array
    {
        $json = [
            'sku' => $this->sku,
            'date' => DateTimes::format($this->date),
            'quantity' => $this->quantity,
        ];
        if ($this->supplierAcceptDate !== null) {
            $json['supplierAcceptDate'] = DateTimes::format($this->supplierAcceptDate);
        }
        return $json;
    }

    /**
     * @param array $json
     * @return static
     */
    public static function fromJson(array $json)
    {
        $acceptDate = null;
        if (isset($json['supplierAcceptDate'])) {
            $acceptDate = DateTimes::parse($json['supplierAcceptDate']);
        }
        return new static(
            $json['sku'],
            DateTimes::parse($json['date']),
            $json['quantity'],
            $acceptDate
        );
    }
}
