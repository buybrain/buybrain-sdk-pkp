<?php
namespace Buybrain\Buybrain\Entity;

use Buybrain\Buybrain\Util\Cast;

/**
 * Information about article pricing for selling.
 *
 * Pricing is specific for an article and a sales channel, with an option to partition it further by supplying a sub
 * channel.
 *
 * Pricing information consists of the total selling price, extra fees and overhead costs, all excluding VAT.
 *
 * Overhead costs are the expected handling costs for e.g. shipping one unit of this article to the buyer.
 *
 * Extra fees are expected fees that will be charged to the buyer on top of the selling price. These are things like
 * shipping costs, but rather than being embedded in the selling price, these costs will be charged to the buyer
 * separately.
 *
 * In order to estimate the effective gross margin of articles when creating purchase orders, all these components are
 * taken into account. Gross margin is calculated as [selling price] - [buying price] + [extra fees] - [overhead costs].
 * Here, the buying price is optimized for dynamically by the buybrain system based on bulk discounts and different
 * suppliers, hence this is not a direct part of the pricing info entity.
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
    private $sellingPrice;
    /** @var Money */
    private $extraFees;
    /** @var Money */
    private $overheadCost;

    /**
     * @param string $sku the unique identifier of the article
     * @param string $channel the sales channel this price applies to
     * @param string|null $subChannel optional further segmentation of sales channel, e.g. different countries
     * @param Money $sellingPrice the current selling price for the SKU in this channel
     * @param Money $extraFees expected extra fees that will be charged to the buyer additional to the selling price
     * @param Money $overheadCost expected overhead / handling costs associated with fulfilling a single unit
     */
    public function __construct(
        $sku,
        $channel,
        $subChannel,
        Money $sellingPrice,
        Money $extraFees,
        Money $overheadCost
    ) {
        $this->sku = (string)$sku;
        $this->channel = (string)$channel;
        $this->subChannel = Cast::toString($subChannel);
        $this->sellingPrice = $sellingPrice;
        $this->extraFees = $extraFees;
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
    public function getSellingPrice()
    {
        return $this->sellingPrice;
    }

    /**
     * @return Money
     */
    public function getExtraFees()
    {
        return $this->extraFees;
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

    public function jsonSerialize(): array
    {
        $data = [
            'sku' => $this->sku,
            'channel' => $this->channel,
            'sellingPrice' => $this->sellingPrice,
            'extraFees' => $this->extraFees,
            'overheadCost' => $this->overheadCost,
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
