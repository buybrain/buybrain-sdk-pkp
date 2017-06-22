<?php
namespace Buybrain\Buybrain\Api;

use Buybrain\Buybrain\Api\Message\AdviseRequest;
use Buybrain\Buybrain\Api\Message\AdviseRequestSku;
use Buybrain\Buybrain\Api\Message\AdviseResponse;
use Buybrain\Buybrain\Api\Message\AdviseResponseSku;
use Buybrain\Buybrain\Api\Mock\FileSystemMockStorage;
use Buybrain\Buybrain\Api\Mock\InMemoryMockStorage;
use Buybrain\Buybrain\Api\Mock\MockAdviseState;
use Buybrain\Buybrain\Api\Mock\MockStorage;
use Exception;

/**
 * Implementation of BuybrainClient for testing purposes that replies to requests in a pre configured way.
 * For reliable operation over multiple requests in multiple PHP processed, the mock client needs to be able to
 * temporarily store information about pending requests somewhere. Inject a persistent TestStorage instance to enable
 * such multi-request scenarios.
 */
class MockBuybrainClient implements BuybrainClient
{
    /** @var MockStorage */
    private $storage;
    /** @var string|null */
    private $nextAdviseId;
    /** @var int */
    private $requestsBeforeFinish = 1;
    /** @var float[] */
    private $defaultCertainty = [0 => 1.0];
    /** @var string|null */
    private $defaultSkuError;
    /** @var AdviseResponseSku[] */
    private $skuResponses = [];

    public function __construct()
    {
        $this->storage = new InMemoryMockStorage();
    }

    /**
     * @param null|string $nextAdviseId
     * @return $this
     */
    public function setNextAdviseId($nextAdviseId)
    {
        $this->nextAdviseId = $nextAdviseId;
        return $this;
    }

    /**
     * @return string
     */
    private function nextAdviseId()
    {
        if ($this->nextAdviseId === null) {
            return $this->createRandomAdviseID();
        } else {
            $result = $this->nextAdviseId;
            $this->nextAdviseId = null;
            return $result;
        }
    }

    /**
     * Use a persistent file system storage for saving advise requests state in between API requests
     *
     * @param string|null $directory the directory to save state in, defaults to a directory in /tmp
     * @return MockBuybrainClient
     */
    public function useFileSystemStorage($directory = null)
    {
        return $this->setStorage(new FileSystemMockStorage($directory));
    }

    /**
     * Inject the mock storage implementation to use for storing state between requests.
     *
     * @param MockStorage $storage
     * @return $this
     */
    public function setStorage(MockStorage $storage)
    {
        $this->storage = $storage;
        return $this;
    }

    /**
     * Configure the number of requests that need to happen before the advise is ready.
     * Defaults to 1 (immediately done).
     *
     * @param int $requestsBeforeFinish
     * @return $this
     */
    public function setRequestsBeforeFinish($requestsBeforeFinish)
    {
        $this->requestsBeforeFinish = $requestsBeforeFinish;
        return $this;
    }

    /**
     * Configure the default certainty for the resulting SKUs. Defaults to 100% chance of a quantity of 0.
     *
     * @param float[] $defaultCertainty
     * @return $this
     */
    public function setDefaultCertainty(array $defaultCertainty)
    {
        $this->defaultCertainty = $defaultCertainty;
        return $this;
    }

    /**
     * Configure an error message to use by default for SKU results. Note that if no SKU specific responses are
     * configured, configuring this will result in an error for _every_ SKU in the result.
     *
     * @param string $errorMessage
     * @return $this
     */
    public function setDefaultSkuError($errorMessage)
    {
        $this->defaultSkuError = $errorMessage;
        return $this;
    }

    /**
     * Configure a successful response with certainties for a specific SKU
     *
     * @param string $sku
     * @param float[] $certainties
     * @return $this
     */
    public function setSkuSuccessResponse($sku, array $certainties)
    {
        $this->skuResponses[$sku] = new AdviseResponseSku($sku, $certainties);
        return $this;
    }

    /**
     * Configure an error response for a specific SKU
     *
     * @param string $sku
     * @param string $error
     * @return $this
     */
    public function setSkuErrorResponse($sku, $error)
    {
        $this->skuResponses[$sku] = (new AdviseResponseSku($sku, []))->setError($error);
        return $this;
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
        $state = new MockAdviseState(
            $this->nextAdviseId(),
            1,
            $request
        );
        return $this->respond($state);
    }

    /**
     * Get the advise report created with createAdvise()
     *
     * @param string $adviseId
     * @return AdviseResponse
     * @throws Exception
     */
    public function getAdvise($adviseId)
    {
        $state = $this->storage->get($adviseId);
        if ($state === null) {
            throw new Exception(sprintf('Advise %s not found', $adviseId));
        }
        return $this->respond($state->incrementNumRequests());
    }

    private function respond(MockAdviseState $state)
    {
        $progress = (float)$state->getNumRequests() / $this->requestsBeforeFinish;
        $done = $progress === 1.0;

        $this->storage->set($state->getAdviseId(), $done ? null : $state);

        return new AdviseResponse(
            $state->getAdviseId(),
            $done ? AdviseResponse::STATUS_COMPLETE : AdviseResponse::STATUS_PENDING,
            $progress,
            $done ? $this->createResultSkus($state->getRequest()) : null
        );
    }

    /**
     * @param AdviseRequest $request
     * @return AdviseResponseSku[]
     */
    private function createResultSkus(AdviseRequest $request)
    {
        return array_map(function (AdviseRequestSku $sku) {
            if (isset($this->skuResponses[$sku->getSku()])) {
                return $this->skuResponses[$sku->getSku()];
            }
            if ($this->defaultSkuError !== null) {
                return (new AdviseResponseSku($sku->getSku(), []))->setError($this->defaultSkuError);
            }
            return new AdviseResponseSku(
                $sku->getSku(),
                $this->defaultCertainty
            );
        }, $request->getSkus());
    }

    /**
     * @return string
     */
    private function createRandomAdviseID()
    {
        $data = openssl_random_pseudo_bytes(16);
        return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
    }
}
