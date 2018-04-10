<?php
namespace Buybrain\Buybrain\Entity;

use JsonSerializable;

/**
 * Details about the way Buybrain advise was used when creating a supplier order
 *
 * @see PurchaseOrder
 */
class UsedAdviseInfo implements JsonSerializable
{
    /** @var string */
    private $adviseId;
    /** @var float */
    private $certainty;

    /**
     * @param string $adviseId
     * @param float $certainty
     */
    public function __construct($adviseId, $certainty)
    {
        $this->adviseId = $adviseId;
        $this->certainty = $certainty;
    }

    /**
     * @return string
     */
    public function getAdviseId()
    {
        return $this->adviseId;
    }

    /**
     * @return float
     */
    public function getCertainty()
    {
        return $this->certainty;
    }

    /**
     * @return array
     */
    public function jsonSerialize()
    {
        return [
            'adviseId' => $this->adviseId,
            'certainty' => $this->certainty,
        ];
    }

    /**
     * @param array $json
     * @return UsedAdviseInfo
     */
    public static function fromJson(array $json)
    {
        return new self(
            $json['adviseId'],
            $json['certainty']
        );
    }
}
