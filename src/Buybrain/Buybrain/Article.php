<?php
namespace Buybrain\Buybrain;

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
    private $typeIds;
    /** @var string|null */
    private $brandId;

    /**
     * @param string $sku the unique identifier of this article
     * @param string $name the name of the article
     * @param string[] $typeIds list of article type IDs
     * @param null|string $brandId optional brand ID
     */
    public function __construct($sku, $name, array $typeIds = [], $brandId = null)
    {
        $this->sku = (string)$sku;
        $this->name = (string)$name;
        $this->typeIds = Cast::toString($typeIds);
        $this->brandId = Cast::toString($brandId);
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
     * @return array
     */
    public function jsonSerialize()
    {
        return [
            'sku' => $this->sku,
            'name' => $this->name,
            'typeIds' => $this->typeIds,
            'brandId' => $this->brandId,
        ];
    }
}