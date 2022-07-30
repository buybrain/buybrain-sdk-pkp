<?php
namespace Buybrain\Buybrain\Entity\SupplierStock;

/**
 * Exactly known supplier stock quantity
 */
class ExactSupplierStock extends SupplierStock
{
    const JSON_TYPE = 'exact';

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

    public function jsonSerialize(): array
    {
        return [
            SupplierStock::JSON_FIELD_TYPE => self::JSON_TYPE,
            'quantity' => $this->quantity,
        ];
    }

    /**
     * @param array $json
     * @return ExactSupplierStock
     */
    public static function fromJson(array $json)
    {
        return new self($json['quantity']);
    }
}
