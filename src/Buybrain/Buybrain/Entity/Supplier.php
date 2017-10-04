<?php
namespace Buybrain\Buybrain\Entity;

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

    /**
     * @param string $id unique identifier for the supplier
     * @param string $name the name of the supplier
     * @param int $leadTime expected number of working days it takes for the supplier to deliver an order
     */
    public function __construct($id, $name, $leadTime)
    {
        $this->id = $id;
        $this->name = $name;
        $this->leadTime = $leadTime;
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
        ];
    }
}
