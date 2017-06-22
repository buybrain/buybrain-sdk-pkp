<?php
namespace Buybrain\Buybrain\Api;

use Buybrain\Buybrain\Api\Message\AdviseRequest;
use Buybrain\Buybrain\Api\Message\AdviseResponse;

/**
 * Interface for clients for communicating with the buybrain platform
 */
interface BuybrainClient
{
    /**
     * Create a new purchase advise report. Depending on how long it takes to generate the full result, the response
     * object may or may not have a 'completed' state. In case it is not completed, use getAdvise() to poll for
     * completion and the final result.
     *
     * @param AdviseRequest $request
     * @return AdviseResponse
     */
    public function createAdvise(AdviseRequest $request);

    /**
     * Get the advise report created with createAdvise()
     *
     * @param string $adviseId
     * @return AdviseResponse
     */
    public function getAdvise($adviseId);
}
