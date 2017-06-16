<?php
namespace Buybrain\Buybrain\Api;

use Buybrain\Buybrain\Api\Message\AdviseRequest;
use Buybrain\Buybrain\Api\Message\AdviseResponse;
use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * Client for communicating with the buybrain platform
 */
class BuybrainClient
{
    const TIMEOUT = 30;

    /** @var BuybrainClientConfig */
    private $config;
    /** @var ClientInterface */
    private $http;

    /**
     * @param BuybrainClientConfig $config
     * @param ClientInterface|null $http optional: the HTTP client instance to use for HTTP requests
     */
    public function __construct(BuybrainClientConfig $config, ClientInterface $http = null)
    {
        $this->config = $config;
        $this->http = $http === null ? new Client() : $http;
    }

    /**
     * Create a new purchase advise report. Depending on how long it takes to generate the full result, the response
     * object may or may not have a 'completed' state. In case it is not completed, use getAdvise() to poll for
     * completion and the final result.
     *
     * @param AdviseRequest $request
     * @return AdviseResponse
     */
    public function createAdvise(AdviseRequest $request)
    {
        $response = $this->request('POST', '/advise', ['json' => $request]);
        return AdviseResponse::fromJson(json_decode($response->getBody(), true));
    }

    /**
     * Get the advise report created with createAdvise()
     *
     * @param string $adviseId
     * @return AdviseResponse
     */
    public function getAdvise($adviseId)
    {
        $response = $this->request('GET', sprintf('/advise/%s', $adviseId));
        return AdviseResponse::fromJson(json_decode($response->getBody(), true));
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
