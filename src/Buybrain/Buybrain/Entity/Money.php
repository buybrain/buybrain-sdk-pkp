<?php
namespace Buybrain\Buybrain\Entity;

use Buybrain\Buybrain\Exception\InvalidArgumentException;
use JsonSerializable;

/**
 * Value class representing monetary values in a specific currency
 */
class Money implements JsonSerializable
{
    /** @var string */
    private $currency;
    /** @var string */
    private $value;

    /**
     * @param string $currency 3 letter ISO currency code
     * @param string $value decimal notation of the monetary value excluding VAT
     * @throws InvalidArgumentException
     */
    public function __construct($currency, $value)
    {
        $this->currency = (string)$currency;
        $this->value = (string)$value;

        if (!preg_match('~^[A-Z]{3}$~', $this->currency)) {
            throw new InvalidArgumentException('Invalid currency code "%s"', $this->currency);
        }
        if (!preg_match('~^\\d+(?:\\.\\d+)?$~', $this->value)) {
            throw new InvalidArgumentException('Invalid numeric value "%s"', $this->value);
        }
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
            'currency' => $this->currency,
            'value' => $this->value
        ];
    }

    /**
     * @param array $json
     * @return Money
     */
    public static function fromJson(array $json)
    {
        return new self($json['currency'], $json['value']);
    }
}
