<?php
namespace Buybrain\Buybrain\Entity;

use Buybrain\Buybrain\Util\Assert;
use Buybrain\Buybrain\Util\Cast;
use Buybrain\Buybrain\Util\DateTimes;
use DateTimeInterface;

/**
 * Representation of a supplier order.
 * A supplier order contains one or multiple purchases and optionally cancellations. These can occur at different dates,
 * since orders might be changed after their creation. Additionally, a supplier order contains deliveries which indicate
 * when items have been physically received from or returned to a supplier. Finally, for purchased items that have not
 * been received yet, expected deliveries indicate when the items are expected to be received.
 */
class PurchaseOrder implements BuybrainEntity
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
    /** @var ExpectedDelivery[] */
    private $expectedDeliveries;
    /** @var PurchaseOrderPrice[] */
    private $prices;
    /** @var UsedAdviseInfo|null */
    private $usedAdvise;
    /** @var string|null */
    private $conceptId;

    /**
     * @param string $id
     * @param string $supplierId
     * @param DateTimeInterface $createDate
     * @param Purchase[] $purchases
     * @param Delivery[] $deliveries
     * @param ExpectedDelivery[] $expectedDeliveries
     * @param PurchaseOrderPrice[] $prices
     */
    public function __construct(
        $id,
        $supplierId,
        DateTimeInterface $createDate,
        array $purchases = [],
        array $deliveries = [],
        array $expectedDeliveries = [],
        array $prices = []
    ) {
        Assert::instancesOf($purchases, Purchase::class);
        Assert::instancesOf($deliveries, Delivery::class);
        Assert::instancesOf($expectedDeliveries, ExpectedDelivery::class);
        $this->id = (string)$id;
        $this->supplierId = (string)$supplierId;
        $this->createDate = $createDate;
        $this->purchases = $purchases;
        $this->deliveries = $deliveries;
        $this->expectedDeliveries = $expectedDeliveries;
        $this->prices = $prices;
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
     * @param ExpectedDelivery $delivery
     * @return $this
     */
    public function addExpectedDelivery(ExpectedDelivery $delivery)
    {
        $this->expectedDeliveries[] = $delivery;
        return $this;
    }

    /**
     * @return ExpectedDelivery[]
     */
    public function getExpectedDeliveries()
    {
        return $this->expectedDeliveries;
    }

    /**
     * @return PurchaseOrderPrice[]
     */
    public function getPrices()
    {
        return $this->prices;
    }

    /**
     * @return UsedAdviseInfo|null
     */
    public function getUsedAdvise()
    {
        return $this->usedAdvise;
    }

    /**
     * @param UsedAdviseInfo $usedAdvise
     * @return $this
     */
    public function setUsedAdvise(UsedAdviseInfo $usedAdvise)
    {
        $this->usedAdvise = $usedAdvise;
        return $this;
    }

    /**
     * @return null|string
     */
    public function getConceptId()
    {
        return $this->conceptId;
    }

    /**
     * @param null|string $conceptId
     * @return $this
     */
    public function setConceptId($conceptId = null)
    {
        $this->conceptId = Cast::toString($conceptId);
        return $this;
    }

    /**
     * @return array
     */
    public function jsonSerialize()
    {
        $json = [
            'id' => $this->id,
            'supplierId' => $this->supplierId,
            'createDate' => DateTimes::format($this->createDate),
            'purchases' => $this->purchases,
            'deliveries' => $this->deliveries,
            'expectedDeliveries' => $this->expectedDeliveries,
            'prices' => $this->prices,
        ];
        if ($this->usedAdvise !== null) {
            $json['usedAdvise'] = $this->usedAdvise;
        }
        if ($this->conceptId !== null) {
            $json['conceptId'] = $this->conceptId;
        }
        return $json;
    }

    /**
     * @param array $json
     * @return PurchaseOrder
     */
    public static function fromJson(array $json)
    {
        $res = new self(
            $json['id'],
            $json['supplierId'],
            DateTimes::parse($json['createDate']),
            array_map([Purchase::class, 'fromJson'], $json['purchases']),
            array_map([Delivery::class, 'fromJson'], $json['deliveries']),
            array_map([ExpectedDelivery::class, 'fromJson'], $json['expectedDeliveries']),
            array_map([PurchaseOrderPrice::class, 'fromJson'], $json['prices'])
        );
        if (isset($json['usedAdvise'])) {
            $res->setUsedAdvise(UsedAdviseInfo::fromJson($json['usedAdvise']));
        }
        if (isset($json['conceptId'])) {
            $res->setConceptId($json['conceptId']);
        }
        return $res;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return self::ENTITY_TYPE;
    }
}
