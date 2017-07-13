<?php
namespace Buybrain\Buybrain\Api\Message;

use JsonSerializable;

/**
 * Part of AdviseRequest message with details about a single SKU
 *
 * @see AdviseRequest
 */
class AdviseRequestSku implements JsonSerializable
{
    /** @var string */
    private $sku;
    /** @var string[] */
    private $channels;
    /** @var string[] */
    private $backorderChannels;

    /**
     * @param string $sku
     * @param string[] $channels the sales channels to consider in the advise
     * @param string[] $backorderChannels the sales channels through which this SKU can be sold without being in stock
     */
    public function __construct($sku, array $channels, array $backorderChannels = [])
    {
        $this->sku = $sku;
        $this->channels = array_values($channels);
        $this->backorderChannels = array_values($backorderChannels);
    }

    /**
     * @return string
     */
    public function getSku()
    {
        return $this->sku;
    }

    /**
     * @return string[] the sales channels to consider in the advise
     */
    public function getChannels()
    {
        return $this->channels;
    }

    /**
     * @return string[] the sales channels through which this SKU can be sold without being in stock
     */
    public function getBackorderChannels()
    {
        return $this->backorderChannels;
    }

    /**
     * @param array $json
     * @return AdviseRequestSku
     */
    public static function fromJson(array $json)
    {
        return new self($json['sku'], $json['chans'], isset($json['boChans']) ? $json['boChans'] : []);
    }

    /**
     * @return array
     */
    public function jsonSerialize()
    {
        $json = ['sku' => $this->sku, 'chans' => $this->channels];
        if (count($this->backorderChannels) > 0) {
            $json['boChans'] = $this->backorderChannels;
        }
        return $json;
    }
}
