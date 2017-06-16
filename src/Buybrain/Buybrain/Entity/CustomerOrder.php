<?php
namespace Buybrain\Buybrain\Entity;

use Buybrain\Buybrain\Util\DateTimes;
use DateTimeInterface;

/**
 * Representation of a customer order.
 * A customer order contains one or multiple sales and optionally returns. These can occur at different dates, since
 * orders might be changed after their creation. Additionally, a customer order contains shipments which indicate when
 * items have been physically shipped to or returned from a customer.
 */
class CustomerOrder implements BuybrainEntity
{
    const ENTITY_TYPE = 'customer.order';

    use AsNervusEntityTrait;
    use EntityIdFactoryTrait;

    /** @var string */
    private $id;
    /** @var DateTimeInterface */
    private $createDate;
    /** @var string */
    private $channel;
    /** @var Sale[] */
    private $sales;
    /** @var Shipment[] */
    private $shipments;

    /**
     * @param string $id
     * @param DateTimeInterface $createDate
     * @param string $channel the initial sales channel
     * @param Sale[] $sales
     * @param Shipment[] $shipments
     */
    public function __construct($id, DateTimeInterface $createDate, $channel, array $sales = [], array $shipments = [])
    {
        $this->id = (string)$id;
        $this->createDate = $createDate;
        $this->channel = $channel;
        $this->sales = $sales;
        $this->shipments = $shipments;
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return DateTimeInterface
     */
    public function getCreateDate()
    {
        return $this->createDate;
    }

    /**
     * @return string the initial sales channel
     */
    public function getChannel()
    {
        return $this->channel;
    }

    /**
     * @param Sale $sale
     * @return $this
     */
    public function addSale(Sale $sale)
    {
        $this->sales[] = $sale;
        return $this;
    }

    /**
     * @return Sale[]
     */
    public function getSales()
    {
        return $this->sales;
    }

    /**
     * @param Shipment $shipment
     * @return $this
     */
    public function addShipment(Shipment $shipment)
    {
        $this->shipments[] = $shipment;
        return $this;
    }

    /**
     * @return Shipment[]
     */
    public function getShipments()
    {
        return $this->shipments;
    }

    /**
     * @return array
     */
    function jsonSerialize()
    {
        return [
            'id' => $this->id,
            'createDate' => DateTimes::format($this->createDate),
            'channel' => $this->channel,
            'sales' => $this->sales,
            'shipments' => $this->shipments,
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
