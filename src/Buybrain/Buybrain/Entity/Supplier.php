<?php
namespace Buybrain\Buybrain\Entity;

use Buybrain\Buybrain\Entity\Supplier\PaymentCondition;

/**
 * Suppliers sell articles that can be purchased according to supplier offers. Once purchased, articles are a part of
 * supplier orders.
 *
 * @see SupplierOffer
 * @see SupplierOrder
 */
class Supplier implements BuybrainEntity
{
    const ENTITY_TYPE = 'supplier';

    use AsNervusEntityTrait;
    use EntityIdFactoryTrait;

    /** @var string */
    private $id;
    /** @var string */
    private $name;
    /** @var int */
    private $leadTime;
    /** @var PaymentCondition[] */
    private $paymentConditions;

    /**
     * @param string $id unique identifier for the supplier
     * @param string $name the name of the supplier
     * @param int $leadTime expected number of working days it takes for the supplier to deliver an order
     * @param PaymentCondition[] $paymentConditions one or multiple payment periods with their associated discounts
     */
    public function __construct($id, $name, $leadTime, array $paymentConditions)
    {
        $this->id = (string)$id;
        $this->name = (string)$name;
        $this->leadTime = (int)$leadTime;
        $this->paymentConditions = $paymentConditions;
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
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return int
     */
    public function getLeadTime()
    {
        return $this->leadTime;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return self::ENTITY_TYPE;
    }

    /**
     * @return array
     */
    public function jsonSerialize()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'leadTime' => $this->leadTime,
            'paymentCond' => $this->paymentConditions
        ];
    }
}
