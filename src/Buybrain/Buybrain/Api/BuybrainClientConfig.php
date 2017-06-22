<?php
namespace Buybrain\Buybrain\Api;

use InvalidArgumentException;

class BuybrainClientConfig
{
    /** @var string */
    private $baseURI = 'https://api.buybrain.io';
    /** @var string */
    private $apiKey;

    /**
     * @param string $apiKey
     */
    public function __construct($apiKey)
    {
        $this->setApiKey($apiKey);
    }

    /**
     * @return string
     */
    public function getBaseURI()
    {
        return $this->baseURI;
    }

    /**
     * @param string $baseURI
     * @return $this
     */
    public function setBaseURI($baseURI)
    {
        $baseURI = rtrim($baseURI, '/');
        if (!filter_var($baseURI, FILTER_VALIDATE_URL)) {
            throw new InvalidArgumentException(sprintf(
                'Invalid buybrain API base URI (%s)',
                $baseURI
            ));
        }
        $this->baseURI = $baseURI;
        return $this;
    }

    /**
     * @return string
     */
    public function getApiKey()
    {
        return $this->apiKey;
    }

    /**
     * @param string $apiKey
     * @return $this
     */
    public function setApiKey($apiKey)
    {
        if (!$apiKey) {
            throw new InvalidArgumentException('Buybrain API key is required');
        }
        $this->apiKey = $apiKey;
        return $this;
    }

    /**
     * @param array $options
     * @return BuybrainClientConfig
     */
    public static function fromOptions(array $options)
    {
        $config = new self($options['apiKey']);
        if (isset($options['baseURI'])) {
            $config->setBaseURI($options['baseURI']);
        }
        return $config;
    }
}
