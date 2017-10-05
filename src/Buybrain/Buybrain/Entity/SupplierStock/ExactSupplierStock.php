<?php
namespace Buybrain\Buybrain\Entity\SupplierStock;

/**
 * Exactly known supplier stock quantity
 */
class ExactSupplierStock implements SupplierStock
{
    /** @var int */
    private $quantity;

    /**
     * @param int $quantity
     */
    public function __construct($quantity)
    {
        $this->quantity = (int)$quantity;
    }

    /**
     * @return int
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * @return array
     */
    public function jsonSerialize()
    {
        return [
            'type' => 'exact',
            'quantity' => $this->quantity,
        ];
    }
}
