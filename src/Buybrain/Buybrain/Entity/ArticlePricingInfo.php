<?php
namespace Buybrain\Buybrain\Entity;

/**
 * Information about article pricing for selling.
 * Pricing is specific for an article and a sales channel, with an option to partition it further by supplying a sub
 * channel.
 * Pricing information consists of the total selling price excluding VAT, and additional data about fixed overhead costs
 * involved with selling a single item, not including the supplier price of the item. This cost is used to determine the
 * effective net margin during supplier order optimization, where the supplier price dynamically depends on things like
 * quantity discounts, different suppliers and current stock value. Overhead costs can vary per (sub) channel because
 * it includes things like costs for shipping to the end customer, which may vary per country.
 *
 * @see Article
 */
class ArticlePricingInfo implements BuybrainEntity
{
    const ENTITY_TYPE = 'article.pricing';

    use AsNervusEntityTrait;
    use EntityIdFactoryTrait;

    /** @var string|null */
    private $id;
    /** @var string */
    private $sku;
    /** @var string */
    private $channel;
    /** @var string|null */
    private $subChannel;
    /** @var Money */
    private $totalPrice;
    /** @var Money */
    private $overheadCost;

    /**
     * @param string $sku the unique identifier of the article
     * @param string $channel the sales channel this price applies to
     * @param string|null $subChannel optional further segmentation of sales channel, e.g. different countries
     * @param Money $totalPrice the current selling price for the SKU in this channel, excluding VAT
     * @param Money $overheadCost fixed overhead costs associated with selling one item, not including the buying price
     */
    public function __construct($sku, $channel, $subChannel, Money $totalPrice, Money $overheadCost)
    {
        $this->sku = $sku;
        $this->channel = $channel;
        $this->subChannel = $subChannel;
        $this->totalPrice = $totalPrice;
        $this->overheadCost = $overheadCost;
    }

    /**
     * @return string
     */
    public function getSku()
    {
        return $this->sku;
    }

    /**
     * @return string
     */
    public function getChannel()
    {
        return $this->channel;
    }

    /**
     * @return string|null
     */
    public function getSubChannel()
    {
        return $this->subChannel;
    }

    /**
     * @return Money
     */
    public function getTotalPrice()
    {
        return $this->totalPrice;
    }

    /**
     * @return Money
     */
    public function getOverheadCost()
    {
        return $this->overheadCost;
    }

    /**
     * Set a custom ID for this price
     *
     * @param string $id
     * @return $this
     */
    public function setId($id)
    {
        $this->id = (string)$id;
        return $this;
    }

    /**
     * @return string
     */
    public function getId()
    {
        if ($this->id !== null) {
            return $this->id;
        }
        return self::getAutoId($this->sku, $this->channel, $this->subChannel);
    }

    /**
     * Generate an ID for this entity based on the SKU, channel and optionally sub channel
     *
     * @param string $sku
     * @param string $channel
     * @param string|null $subChannel
     * @return string
     */
    public static function getAutoId($sku, $channel, $subChannel = null)
    {
        $parts = [$sku, $channel];
        if ($subChannel !== null) {
            $parts[] = $subChannel;
        }
        return implode('|', $parts);
    }

    /**
     * Parse an auto generated ID back into the original components (SKU, channel and sub channel)
     *
     * @param string $autoId
     * @return array of [string, string, string|null]
     */
    public static function parseAutoId($autoId)
    {
        $parts = explode('|', $autoId);
        if (count($parts) === 2) {
            $parts[] = null;
        }
        return $parts;
    }

    /**
     * @return array
     */
    public function jsonSerialize()
    {
        $data = [
            'sku' => $this->sku,
            'channel' => $this->channel,
            'totalPrice' => $this->totalPrice,
            'overheadCost' => $this->overheadCost
        ];
        if ($this->subChannel !== null) {
            $data['subChannel'] = $this->subChannel;
        }
        if ($this->id !== null) {
            $data['id'] = $this->id;
        }
        return $data;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return self::ENTITY_TYPE;
    }
}
