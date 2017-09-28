<?php
namespace Buybrain\Buybrain\Entity;

/**
 * Current selling price for an article in a specific channel and optionally sub channel
 *
 * @see Article
 */
class ArticleSellingPrice implements BuybrainEntity
{
    const ENTITY_TYPE = 'article.price';

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
    private $price;

    /**
     * @param string $sku the unique identifier of the article
     * @param string $channel the sales channel this price applies to
     * @param string|null $subChannel optional further segmentation of sales channel, e.g. different countries
     * @param Money $price the current selling price for the SKU in this channel, excluding VAT
     */
    public function __construct($sku, $channel, $subChannel, Money $price)
    {
        $this->sku = $sku;
        $this->channel = $channel;
        $this->subChannel = $subChannel;
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
     * Generate an ID for this entity based on the SKU, channel and start date
     *
     * @param string $sku
     * @param string $channel
     * @param string|null $subChannel
     * @return string
     */
    public static function getAutoId($sku, $channel, $subChannel = null)
    {
        return sprintf(
            '%s|%s|%s',
            $sku,
            $channel,
            $subChannel === null ? '' : $subChannel
        );
    }

    /**
     * @return array
     */
    public function jsonSerialize()
    {
        $data = [
            'sku' => $this->sku,
            'channel' => $this->channel,
            'price' => $this->price,
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
