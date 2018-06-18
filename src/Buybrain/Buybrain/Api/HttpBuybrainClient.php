<?php
namespace Buybrain\Buybrain\Api;

use Buybrain\Buybrain\Exception\InvalidArgumentException;
use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * HTTP client for communicating with the buybrain platform
 */
class HttpBuybrainClient implements BuybrainClient
{
    const TIMEOUT = 60;
    /** @var BuybrainClientConfig */
    private $config;
    /** @var ClientInterface */
    private $http;

    /**
     * @param array|BuybrainClientConfig $config
     * @param ClientInterface|null $http optional: the HTTP client instance to use for HTTP requests
     * @throws InvalidArgumentException
     */
    public function __construct($config, ClientInterface $http = null)
    {
        if (is_array($config)) {
            $config = BuybrainClientConfig::fromOptions($config);
        }
        if (!$config instanceof BuybrainClientConfig) {
            throw new InvalidArgumentException('Invalid configuration');
        }
        $this->config = $config;
        $this->http = $http === null ? new Client() : $http;
    }

    /**
     * @param string $method
     * @param string $relativeURI
     * @param array $options
     * @return ResponseInterface
     */
    private function request($method, $relativeURI, array $options = [])
    {
        return $this->http->request(
            $method,
            $this->config->getBaseURI() . '/' . ltrim($relativeURI, '/'),
            array_merge(
                [
                    'headers' => [
                        'Accept' => 'application/json',
                        'Apikey' => $this->config->getApiKey(),
                    ],
                    'timeout' => self::TIMEOUT,
                ],
                $options
            )
        );
    }
}
