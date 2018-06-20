<?php
namespace Buybrain\Buybrain\Entity;

use JsonSerializable;

/**
 * The effective purchase or selling price for an article in an order excluding VAT
 *
 * @see PurchaseOrder
 * @see SalesOrder
 */
class OrderSkuPrice implements JsonSerializable
{
    /** @var string */
    private $sku;
    /** @var Money */
    private $price;

    /**
     * @param string $sku
     * @param Money $price
     */
    public function __construct($sku, Money $price)
    {
        $this->sku = (string)$sku;
        $this->price = $price;
    }

    /**
     * @return string
     */
    public function getSku()
    {
        return $this->sku;
    }

    /**
     * @return Money
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @return array
     */
    public function jsonSerialize()
    {
        return [
            'sku' => $this->sku,
            'price' => $this->price,
        ];
    }

    /**
     * @param array $json
     * @return static
     */
    public static function fromJson(array $json)
    {
        return new static(
            $json['sku'],
            Money::fromJson($json['price'])
        );
    }
}
