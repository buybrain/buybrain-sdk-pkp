<?php
namespace Buybrain\Buybrain\Entity;

use Buybrain\Buybrain\Util\Assert;
use Buybrain\Buybrain\Util\DateTimes;
use DateTimeInterface;

/**
 * Representation of a sales order.
 *
 * A order order contains one or multiple sales and optionally cancellations. These can occur at different dates,
 * since orders might be changed after their creation. Additionally, a order order contains reservations which
 * indicate a claim on physical stock to be assigned to this order.
 */
class SalesOrder implements BuybrainEntity
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
    /** @var string|null */
    private $subChannel;
    /** @var Sale[] */
    private $sales;
    /** @var Reservation[] */
    private $reservations;
    /** @var OrderSkuPrice[] */
    private $prices;
    /** @var Money|null */
    private $extraFees;
    /** @var Money|null */
    private $overheadCost;

    /**
     * @param string $id
     * @param DateTimeInterface $createDate
     * @param string $channel the initial sales channel
     * @param Sale[] $sales
     * @param Reservation[] $reservations
     * @param OrderSkuPrice[] $prices
     * @param Money|null $extraFees
     * @param Money|null $overheadCost
     */
    public function __construct(
        $id,
        DateTimeInterface $createDate,
        $channel,
        array $sales = [],
        array $reservations = [],
        array $prices = [],
        Money $extraFees = null,
        Money $overheadCost = null
    ) {
        Assert::instancesOf($sales, Sale::class);
        Assert::instancesOf($reservations, Reservation::class);
        Assert::instancesOf($prices, OrderSkuPrice::class);

        $this->id = (string)$id;
        $this->createDate = $createDate;
        $this->channel = (string)$channel;
        $this->sales = $sales;
        $this->reservations = $reservations;
        $this->prices = $prices;
        $this->extraFees = $extraFees;
        $this->overheadCost = $overheadCost;
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
     * @param null|string $subChannel
     * @return $this
     */
    public function setSubChannel($subChannel)
    {
        $this->subChannel = $subChannel;
        return $this;
    }

    /**
     * @return null|string
     */
    public function getSubChannel()
    {
        return $this->subChannel;
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
     * @param Reservation $reservation
     * @return $this
     */
    public function addReservation(Reservation $reservation)
    {
        $this->reservations[] = $reservation;
        return $this;
    }

    /**
     * @return Reservation[]
     */
    public function getReservations()
    {
        return $this->reservations;
    }

    /**
     * @param OrderSkuPrice $price
     * @return $this
     */
    public function addPrice(OrderSkuPrice $price)
    {
        $this->prices[] = $price;
        return $this;
    }

    /**
     * @return OrderSkuPrice[]
     */
    public function getPrices()
    {
        return $this->prices;
    }

    /**
     * @return Money|null
     */
    public function getExtraFees()
    {
        return $this->extraFees;
    }

    /**
     * @param Money $extraFees
     * @return $this
     */
    public function setExtraFees(Money $extraFees)
    {
        $this->extraFees = $extraFees;
        return $this;
    }

    /**
     * @return Money|null
     */
    public function getOverheadCost()
    {
        return $this->overheadCost;
    }

    /**
     * @param Money $overheadCost
     * @return $this
     */
    public function setOverheadCost(Money $overheadCost)
    {
        $this->overheadCost = $overheadCost;
        return $this;
    }

    /**
     * @return array
     */
    public function jsonSerialize()
    {
        $json = [
            'id' => $this->id,
            'createDate' => DateTimes::format($this->createDate),
            'channel' => $this->channel,
            'sales' => $this->sales,
            'reservations' => $this->reservations,
            'prices' => $this->prices,
        ];
        if ($this->subChannel !== null) {
            $json['subChannel'] = $this->subChannel;
        }
        if ($this->extraFees !== null) {
            $json['extraFees'] = $this->extraFees;
        }
        if ($this->overheadCost !== null) {
            $json['overheadCost'] = $this->overheadCost;
        }
        return $json;
    }

    /**
     * @param array $json
     * @return SalesOrder
     */
    public static function fromJson(array $json)
    {
        $res = new self(
            $json['id'],
            DateTimes::parse($json['createDate']),
            $json['channel'],
            array_map([Sale::class, 'fromJson'], $json['sales']),
            array_map([Reservation::class, 'fromJson'], $json['reservations']),
            array_map([OrderSkuPrice::class, 'fromJson'], $json['prices'])
        );
        if (isset($json['subChannel'])) {
            $res->setSubChannel($json['subChannel']);
        }
        if (isset($json['extraFees'])) {
            $res->setExtraFees(Money::fromJson($json['extraFees']));
        }
        if (isset($json['overheadCost'])) {
            $res->setOverheadCost(Money::fromJson($json['overheadCost']));
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
