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
    /** @var Money */
    private $price;

    /**
     * @param string $sku
     * @param int $quantity
     * @param Money $price
     */
    public function __construct($sku, $quantity, Money $price)
    {
        $this->sku = (string)$sku;
        $this->quantity = (int)$quantity;
        $this->price = $price;

        Assert::greaterThan($this->quantity, 0, 'Invalid PO advice article quantity');
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
            Money::fromJson($json['price'])
        );
    }
}
