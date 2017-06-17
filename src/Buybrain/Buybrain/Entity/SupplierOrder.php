<?php
namespace Buybrain\Buybrain\Entity;

use Buybrain\Buybrain\Util\DateTimes;
use DateTimeInterface;

/**
 * Representation of a supplier order.
 * A supplier order contains one or multiple purchases and optionally cancellations. These can occur at different dates,
 * since orders might be changed after their creation. Additionally, a supplier order contains deliveries which indicate
 * when items have been physically received from or returned to a supplier. Finally, for purchased items that have not
 * been received yet, expected deliveries indicate when the items are expected to be received.
 */
class SupplierOrder implements BuybrainEntity
{
    const ENTITY_TYPE = 'supplier.order';

    use AsNervusEntityTrait;
    use EntityIdFactoryTrait;

    /** @var string */
    private $id;
    /** @var string */
    private $supplierId;
    /** @var DateTimeInterface */
    private $createDate;
    /** @var Purchase[] */
    private $purchases;
    /** @var Delivery[] */
    private $deliveries;
    /** @var Delivery[] */
    private $expectedDeliveries;

    /**
     * @param string $id
     * @param string $supplierId
     * @param DateTimeInterface $createDate
     * @param Purchase[] $purchases
     * @param Delivery[] $deliveries
     * @param Delivery[] $expectedDeliveries
     */
    public function __construct(
        $id,
        $supplierId,
        DateTimeInterface $createDate,
        array $purchases = [],
        array $deliveries = [],
        array $expectedDeliveries = []
    ) {
        $this->id = $id;
        $this->supplierId = $supplierId;
        $this->createDate = $createDate;
        $this->purchases = $purchases;
        $this->deliveries = $deliveries;
        $this->expectedDeliveries = $expectedDeliveries;
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getSupplierId()
    {
        return $this->supplierId;
    }

    /**
     * @return DateTimeInterface
     */
    public function getCreateDate()
    {
        return $this->createDate;
    }

    /**
     * @param Purchase $purchase
     * @return $this
     */
    public function addPurchase(Purchase $purchase)
    {
        $this->purchases[] = $purchase;
        return $this;
    }

    /**
     * @return Purchase[]
     */
    public function getPurchases()
    {
        return $this->purchases;
    }

    /**
     * @param Delivery $delivery
     * @return $this
     */
    public function addDelivery(Delivery $delivery)
    {
        $this->deliveries[] = $delivery;
        return $this;
    }

    /**
     * @return Delivery[]
     */
    public function getDeliveries()
    {
        return $this->deliveries;
    }

    /**
     * @param Delivery $delivery
     * @return $this
     */
    public function addExpectedDelivery(Delivery $delivery)
    {
        $this->expectedDeliveries[] = $delivery;
        return $this;
    }

    /**
     * @return Delivery[]
     */
    public function getExpectedDeliveries()
    {
        return $this->expectedDeliveries;
    }

    /**
     * @return array
     */
    function jsonSerialize()
    {
        return [
            'id' => $this->id,
            'supplierId' => $this->supplierId,
            'createDate' => DateTimes::format($this->createDate),
            'purchases' => $this->purchases,
            'deliveries' => $this->deliveries,
            'expectedDeliveries' => $this->expectedDeliveries,
        ];
    }

    /**
     * @return string
     */
    public function getType()
    {
        return self::ENTITY_TYPE;
    }
}