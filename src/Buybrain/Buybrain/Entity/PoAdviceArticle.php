<?php
namespace Buybrain\Buybrain\Entity;

use Buybrain\Buybrain\Util\Assert;
use JsonSerializable;

/**
 * @see PoAdvice
 */
class PoAdviceArticle implements JsonSerializable
{
    /** @var string */
    private $sku;
    /** @var int */
    private $quantity;
    /** @var int */
    private $minimumQuantity;
    /** @var Money */
    private $price;

    /**
     * @param string $sku
     * @param int $quantity
     * @param int $minimumQuantity
     * @param Money $price
     */
    public function __construct($sku, $quantity, $minimumQuantity, Money $price)
    {
        $this->sku = (string)$sku;
        $this->quantity = (int)$quantity;
        $this->minimumQuantity = (int)$minimumQuantity;
        $this->price = $price;

        Assert::greaterThan($this->quantity, 0, 'Invalid PO advice article quantity');
        Assert::greaterThanOrEqual($this->minimumQuantity, 0, 'Invalid PO advice article minimum quantity');
        Assert::greaterThan((float)$this->price->getValue(), 0, 'Invalid PO advice article price');
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
     * @return int
     */
    public function getMinimumQuantity()
    {
        return $this->minimumQuantity;
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
            'quantity' => $this->quantity,
            'minimumQuantity' => $this->minimumQuantity,
            'price' => $this->price,
        ];
    }

    /**
     * @param array $json
     * @return PoAdviceArticle
     */
    public static function fromJson(array $json)
    {
        return new PoAdviceArticle(
            $json['sku'],
            $json['quantity'],
            $json['minimumQuantity'],
            Money::fromJson($json['price'])
        );
    }
}
