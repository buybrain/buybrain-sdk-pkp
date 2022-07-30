<?php
namespace Buybrain\Buybrain\Entity;

use Buybrain\Buybrain\Util\Assert;
use Buybrain\Buybrain\Util\Cast;
use JsonSerializable;

/**
 * Represents a supplier price applicable for a particular quantity or quantity range
 *
 * @see SupplierOffer
 */
class SupplierPrice implements JsonSerializable
{
    /** @var int */
    private $from;
    /** @var int|null */
    private $to;
    /** @var Money */
    private $price;

    /**
     * @param int $from the quantity starting from which this price is applicable
     * @param int|null $to the quantity where the price stops being applicable (so, exclusive)
     * @param Money $price the supplier price for this quantity range excluding VAT
     */
    public function __construct($from, $to, Money $price)
    {
        Assert::greaterThan((float)$price->getValue(), 0.0);

        $this->from = (int)$from;
        $this->to = Cast::toInt($to);
        $this->price = $price;
    }

    /**
     * @return int
     */
    public function getFrom()
    {
        return $this->from;
    }

    /**
     * @return int|null
     */
    public function getTo()
    {
        return $this->to;
    }

    /**
     * @return Money
     */
    public function getPrice()
    {
        return $this->price;
    }

    public function jsonSerialize(): array
    {
        return [
            'from' => $this->from,
            'to' => $this->to,
            'currency' => $this->price->getCurrency(),
            'value' => $this->price->getValue()
        ];
    }
}
