<?php
namespace Buybrain\Buybrain\Api\Message;

use JsonSerializable;

/**
 * Part of AdviseResponse with the result for a single SKU
 *
 * @see AdviseResponse
 */
class AdviseResponseSku implements JsonSerializable
{
    /** @var string */
    private $sku;
    /** @var float[] */
    private $certainties;

    /**
     * @param string $sku
     * @param float[] $certainties quantities to purchase as keys with the probabilities of having enough as values
     */
    public function __construct($sku, array $certainties)
    {
        $this->sku = $sku;
        $this->certainties = $certainties;
    }

    /**
     * @param array $json
     * @return AdviseResponseSku
     */
    public static function fromJson(array $json)
    {
        return new self($json['sku'], $json['certainties']);
    }

    /**
     * @return array
     */
    public function jsonSerialize()
    {
        return [
            'sku' => $this->sku,
            'certainties' => $this->certainties
        ];
    }
}
