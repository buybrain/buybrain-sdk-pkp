<?php
namespace Buybrain\Buybrain;

use DateTime;
use DateTimeInterface;

/**
 * Representation of a customer order.
 * A customer order contains one or multiple sales and optionally returns. These can occur at different dates, since
 * orders might be changed after their creation.
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
    /** @var Sale[] */
    private $sales;

    /**
     * @param string $id
     * @param DateTimeInterface $createDate
     * @param Sale[] $sales
     */
    public function __construct($id, DateTimeInterface $createDate, array $sales = [])
    {
        $this->id = (string)$id;
        $this->createDate = $createDate;
        $this->sales = $sales;
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
     * @return array
     */
    function jsonSerialize()
    {
        return [
            'id' => $this->id,
            'createDate' => $this->createDate->format(DateTime::W3C),
            'sales' => $this->sales,
        ];
    }
}