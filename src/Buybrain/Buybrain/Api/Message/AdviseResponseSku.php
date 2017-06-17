<?php
namespace Buybrain\Buybrain\Api\Message;

use JsonSerializable;
use RuntimeException;

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
    /** @var string|null */
    private $error;

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
     * @return string
     */
    public function getSku()
    {
        return $this->sku;
    }

    /**
     * @return float[] quantities to purchase as keys with the probabilities of having enough as values
     */
    public function getCertainties()
    {
        if ($this->hasError()) {
            throw new RuntimeException(sprintf(
                'Cannot get certainties for SKU %s because an error occurred (%s)',
                $this->sku,
                $this->error
            ));
        }
        return $this->certainties;
    }

    /**
     * @param string $error error message in case something went wrong while creating advise for this SKU
     * @return $this
     */
    public function setError($error)
    {
        $this->error = $error;
        return $this;
    }

    /**
     * @return bool whether an error occurred while creating advise for this SKU
     */
    public function hasError()
    {
        return $this->error !== null;
    }

    /**
     * @return null|string error message in case something went wrong while creating advise for this SKU
     */
    public function getError()
    {
        return $this->error;
    }

    /**
     * @param array $json
     * @return AdviseResponseSku
     */
    public static function fromJson(array $json)
    {
        $result = new self($json['sku'], $json['certainties']);
        if (isset($json['error'])) {
            $result->setError($json['error']);
        }
        return $result;
    }

    /**
     * @return array
     */
    public function jsonSerialize()
    {
        $json = [
            'sku' => $this->sku,
            'certainties' => $this->certainties,
        ];
        if ($this->error !== null) {
            $json['error'] = $this->error;
        }
        return $json;
    }
}
