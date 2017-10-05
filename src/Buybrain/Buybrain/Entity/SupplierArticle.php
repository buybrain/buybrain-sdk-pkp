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
    /** @var int */
    private $orderQuantity = 1;
    /** @var int */
    private $minimumOrderQuantity = 1;
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
     * @return int
     */
    public function getOrderQuantity()
    {
        return $this->orderQuantity;
    }

    /**
     * Set the incremental quantity this item is sold by. When ordering this article at this supplier, the purchased
     * amount must be a multiple of this value. Defaults to 1.
     *
     * @param int $orderQuantity
     * @return $this
     */
    public function setOrderQuantity($orderQuantity)
    {
        $this->orderQuantity = (int)$orderQuantity;
        return $this;
    }

    /**
     * @return int
     */
    public function getMinimumOrderQuantity()
    {
        return $this->minimumOrderQuantity;
    }

    /**
     * Set the smallest quantity of this article that may be purchased at this supplier. When combined with an 'order
     * quantity' (see setOrderQuantity()), the effective smallest quantity that can be purchased is this value rounded
     * up to the nearest multiple of `order quantity`. Defaults to 1.
     *
     * @param int $minimumOrderQuantity
     * @return $this
     */
    public function setMinimumOrderQuantity($minimumOrderQuantity)
    {
        $this->minimumOrderQuantity = (int)$minimumOrderQuantity;
        return $this;
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
            'orderQuantity' => $this->orderQuantity,
            'moq' => $this->minimumOrderQuantity,
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
