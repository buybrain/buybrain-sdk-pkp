<?php
namespace Buybrain\Buybrain\Entity;

use Buybrain\Buybrain\Entity\SupplierStock\SupplierStock;
use Buybrain\Buybrain\Util\DateTimes;
use DateTimeInterface;

/**
 * Current information about an article sold by a supplier.
 */
class SupplierArticle implements BuybrainEntity
{
    const ENTITY_TYPE = 'supplier.offer';

    use AsNervusEntityTrait;
    use EntityIdFactoryTrait;

    /** @var string|null */
    private $id;
    /** @var string */
    private $supplierId;
    /** @var string */
    private $sku;
    /** @var SupplierStock */
    private $stock;
    /** @var SupplierPrice[] */
    private $prices;
    /** @var DateTimeInterface|null */
    private $availableFromDate;

    /**
     * @param string $supplierId
     * @param string $sku the unique identifier of the article
     * @param SupplierStock $stock the current stock of the supplier
     * @param SupplierPrice[] $prices the supplier's selling prices
     * @param DateTimeInterface|null $availableFromDate optional date indicating when this item becomes available for
     *                               ordering. Any orders before this date will not be fulfilled until this date.
     */
    public function __construct(
        $supplierId,
        $sku,
        SupplierStock $stock,
        array $prices,
        DateTimeInterface $availableFromDate = null
    ) {
        $this->supplierId = (string)$supplierId;
        $this->sku = (string)$sku;
        $this->stock = $stock;
        $this->prices = $prices;
        $this->availableFromDate = $availableFromDate;
    }

    /**
     * @return string
     */
    public function getSupplierId()
    {
        return $this->supplierId;
    }

    /**
     * @return string
     */
    public function getSku()
    {
        return $this->sku;
    }

    /**
     * @return SupplierStock
     */
    public function getStock()
    {
        return $this->stock;
    }

    /**
     * @return SupplierPrice[]
     */
    public function getPrices()
    {
        return $this->prices;
    }

    /**
     * @return DateTimeInterface|null
     */
    public function getAvailableFromDate()
    {
        return $this->availableFromDate;
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
        return self::getAutoId($this->supplierId, $this->sku);
    }

    /**
     * Generate an ID for this entity based on the supplier ID and SKU
     *
     * @param string $supplierId
     * @param string $sku
     * @return string
     */
    public static function getAutoId($supplierId, $sku)
    {
        return sprintf('%s|%s', $supplierId, $sku);
    }

    /**
     * Parse an auto generated ID back into the original components (supplier ID and SKU)
     *
     * @param string $autoId
     * @return array of [string, string]
     */
    public static function parseAutoId($autoId)
    {
        return explode('|', $autoId);
    }

    /**
     * @return array
     */
    public function jsonSerialize()
    {
        $data = [
            'supplierId' => $this->supplierId,
            'sku' => $this->sku,
            'stock' => $this->stock,
            'prices' => $this->prices,
        ];
        if ($this->availableFromDate !== null) {
            $data['availableFromDate'] = DateTimes::format($this->availableFromDate);
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
