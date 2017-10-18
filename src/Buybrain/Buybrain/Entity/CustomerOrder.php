<?php
namespace Buybrain\Buybrain\Entity;

use Buybrain\Buybrain\Util\Assert;
use Buybrain\Buybrain\Util\DateTimes;
use DateTimeInterface;

/**
 * Representation of a customer order.
 *
 * A customer order contains one or multiple sales and optionally cancellations. These can occur at different dates,
 * since orders might be changed after their creation. Additionally, a customer order contains reservations which
 * indicate a claim on physical stock to be assigned to this order.
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
    /** @var Reservation[] */
    private $reservations;

    /**
     * @param string $id
     * @param DateTimeInterface $createDate
     * @param string $channel the initial sales channel
     * @param Sale[] $sales
     * @param Reservation[] $reservations
     */
    public function __construct($id, DateTimeInterface $createDate, $channel, array $sales = [], array $reservations = [])
    {
        Assert::instancesOf($sales, Sale::class);
        Assert::instancesOf($reservations, Reservation::class);
        $this->id = (string)$id;
        $this->createDate = $createDate;
        $this->channel = (string)$channel;
        $this->sales = $sales;
        $this->reservations = $reservations;
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
     * @return array
     */
    function jsonSerialize()
    {
        return [
            'id' => $this->id,
            'createDate' => DateTimes::format($this->createDate),
            'channel' => $this->channel,
            'sales' => $this->sales,
            'reservations' => $this->reservations,
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
