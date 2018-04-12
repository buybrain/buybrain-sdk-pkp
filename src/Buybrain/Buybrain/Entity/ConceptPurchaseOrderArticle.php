<?php
namespace Buybrain\Buybrain\Entity;

use JsonSerializable;

/**
 * @see ConceptPurchaseOrder
 */
class ConceptPurchaseOrderArticle implements JsonSerializable
{
    /** @var string */
    private $sku;
    /** @var int */
    private $quantity;
    /** @var Money */
    private $itemPrice;

    /**
     * @param string $sku
     * @param int $quantity
     * @param Money $itemPrice the price for a single unit
     */
    public function __construct($sku, $quantity, Money $itemPrice)
    {
        $this->sku = (string)$sku;
        $this->quantity = (int)$quantity;
        $this->itemPrice = $itemPrice;
    }

    /**
     * @return string
     */
    public function getSku()
    {
        return $this->sku;
    }

    /**
     * @return int
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * @return Money
     */
    public function getItemPrice()
    {
        return $this->itemPrice;
    }

    public function jsonSerialize()
    {
        return [
            'sku' => $this->sku,
            'quantity' => $this->quantity,
            'itemPrice' => $this->itemPrice,
        ];
    }

    /**
     * @param array $json
     * @return ConceptPurchaseOrderArticle
     */
    public static function fromJson(array $json)
    {
        return new self(
            $json['sku'],
            $json['quantity'],
            Money::fromJson($json['itemPrice'])
        );
    }
}
