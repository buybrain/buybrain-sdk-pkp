<?php
namespace Buybrain\Buybrain\Entity;

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
    /** @var string */
    private $currency;
    /** @var string */
    private $value;

    /**
     * @param int $from the quantity starting from which this price is applicable
     * @param int|null $to the quantity where the price stops being applicable (so, exclusive)
     * @param string $currency 3 letter ISO currency code
     * @param string $value decimal notation of the supplier price excluding VAT
     */
    public function __construct($from, $to, $currency, $value)
    {
        $this->from = (int)$from;
        $this->to = Cast::toInt($to);
        $this->currency = (string)$currency;
        $this->value = (string)$value;
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
     * @return string
     */
    public function getCurrency()
    {
        return $this->currency;
    }

    /**
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }


    /**
     * @return array
     */
    public function jsonSerialize()
    {
        return [
            'from' => $this->from,
            'to' => $this->to,
            'currency' => $this->currency,
            'value' => $this->value
        ];
    }
}
