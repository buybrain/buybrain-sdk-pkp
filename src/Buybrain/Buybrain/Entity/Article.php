<?php
namespace Buybrain\Buybrain\Entity;

use Buybrain\Buybrain\Util\Cast;

/**
 * Representation of an article with a single SKU. This is the smallest sellable unit in any supply chain.
 */
class Article implements BuybrainEntity
{
    const ENTITY_TYPE = 'article';

    use AsNervusEntityTrait;
    use EntityIdFactoryTrait;

    /** @var string */
    private $sku;
    /** @var string */
    private $name;
    /** @var string[] */
    private $stockChannels;
    /** @var string[] */
    private $typeIds;
    /** @var string|null */
    private $brandId;
    /** @var bool */
    private $endOfLife;

    /**
     * @param string $sku the unique identifier of this article
     * @param string $name the name of the article
     * @param string[] $stockChannels the sales channels for which to potentially purchase stock in addition to the
     *      minimum amount required for fulfilling reservations. Leave empty if this article is not supposed to be
     *      taken in stock at all.
     * @param string[] $typeIds list of article type IDs
     * @param null|string $brandId optional brand ID,
     * @param bool $endOfLife articles marked as end-of-life will not be purchased or sold anymore. End-of-life articles
     *      will under no circumstance be included in future PO advice, even if there are pending reservations.
     */
    public function __construct(
        $sku,
        $name,
        array $stockChannels,
        array $typeIds = [],
        $brandId = null,
        $endOfLife = false
    ) {
        $this->sku = (string)$sku;
        $this->name = (string)$name;
        $this->stockChannels = array_unique(Cast::toString($stockChannels));
        sort($this->stockChannels);
        $this->typeIds = Cast::toString($typeIds);
        $this->brandId = Cast::toString($brandId);
        $this->endOfLife = (bool)$endOfLife;
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
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return string[]
     */
    public function getStockChannels()
    {
        return $this->stockChannels;
    }

    /**
     * @return string[]
     */
    public function getTypeIds()
    {
        return $this->typeIds;
    }

    /**
     * @return null|string
     */
    public function getBrandId()
    {
        return $this->brandId;
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->sku;
    }

    /**
     * @return bool
     */
    public function isEndOfLife()
    {
        return $this->endOfLife;
    }

    /**
     * @return array
     */
    public function jsonSerialize()
    {
        return [
            'sku' => $this->sku,
            'name' => $this->name,
            'stockChannels' => $this->stockChannels,
            'typeIds' => $this->typeIds,
            'brandId' => $this->brandId,
            'endOfLife' => $this->endOfLife,
        ];
    }

    /**
     * @param array $json
     * @return Article
     */
    public static function fromJson(array $json)
    {
        return new self(
            $json['sku'],
            $json['name'],
            $json['stockChannels'],
            $json['typeIds'],
            $json['brandId'],
            $json['endOfLife']
        );
    }

    /**
     * @return string
     */
    public function getType()
    {
        return self::ENTITY_TYPE;
    }
}
