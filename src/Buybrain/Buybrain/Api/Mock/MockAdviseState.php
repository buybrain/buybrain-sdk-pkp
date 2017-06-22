<?php
namespace Buybrain\Buybrain\Api\Mock;

use Buybrain\Buybrain\Api\Message\AdviseRequest;
use JsonSerializable;

class MockAdviseState implements JsonSerializable
{
    /** @var string */
    private $adviseId;
    /** @var int */
    private $numRequests;
    /** @var AdviseRequest */
    private $request;

    /**
     * @param string $adviseId
     * @param int $numRequests
     * @param AdviseRequest $request
     */
    public function __construct($adviseId, $numRequests, AdviseRequest $request)
    {
        $this->adviseId = $adviseId;
        $this->numRequests = $numRequests;
        $this->request = $request;
    }

    /**
     * @return string
     */
    public function getAdviseId()
    {
        return $this->adviseId;
    }

    /**
     * @return $this
     */
    public function incrementNumRequests()
    {
        $this->numRequests++;
        return $this;
    }

    /**
     * @return int
     */
    public function getNumRequests()
    {
        return $this->numRequests;
    }

    /**
     * @return AdviseRequest
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * @param array $json
     * @return MockAdviseState
     */
    public static function fromJson(array $json)
    {
        return new self(
            $json['adviseId'],
            $json['numRequests'],
            AdviseRequest::fromJson($json['request'])
        );
    }

    /**
     * @return array
     */
    public function jsonSerialize()
    {
        return [
            'adviseId' => $this->adviseId,
            'numRequests' => $this->numRequests,
            'request' => $this->request,
        ];
    }
}
