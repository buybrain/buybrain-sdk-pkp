<?php
namespace Buybrain\Buybrain;

use DateTime;
use DateTimeInterface;
use JsonSerializable;

/**
 * Represents the sale of a particular SKU at a particular date through a sales channel.
 * Can represent a cancellation/return by using a negative quantity.
 */
class Sale implements JsonSerializable
{
    /** @var string */
    private $sku;
    /** @var DateTimeInterface */
    private $date;
    /** @var int */
    private $quantity;
    /** @var string */
    private $channel;

    /**
     * @param string $sku
     * @param DateTimeInterface $date
     * @param int $quantity
     * @param string $channel
     */
    public function __construct($sku, DateTimeInterface $date, $quantity, $channel)
    {
        $this->sku = $sku;
        $this->date = $date;
        $this->quantity = $quantity;
        $this->channel = $channel;
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
     * @return string
     */
    public function getChannel()
    {
        return $this->channel;
    }

    /**
     * @return array
     */
    function jsonSerialize()
    {
        return [
            'sku' => $this->sku,
            'date' => $this->date->format(DateTime::W3C),
            'quantity' => $this->quantity,
            'channel' => $this->channel,
        ];
    }
}