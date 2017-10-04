<?php
namespace Buybrain\Buybrain\Api;

use Buybrain\Buybrain\Api\Message\AdviseRequest;
use Buybrain\Buybrain\Api\Message\AdviseRequestSku;
use Buybrain\Buybrain\Api\Message\AdviseResponse;
use Buybrain\Buybrain\Api\Message\AdviseResponseSku;
use Buybrain\Buybrain\Util\DateTimes;
use PHPUnit\Framework\TestCase;

class MockBuybrainClientTest extends TestCase
{
    const ADVISE_ID = '00000000-0000-0000-0000-000000000000';

    /** @var MockBuybrainClient */
    private $SUT;
    /** @var AdviseRequest */
    private $request;

    public function setUp()
    {
        $this->SUT = new MockBuybrainClient();
        $this->SUT->setNextAdviseId(self::ADVISE_ID);

        $this->request = new AdviseRequest(
            DateTimes::parse('2017-01-01'),
            DateTimes::parse('2017-02-01'),
            [
                new AdviseRequestSku('1', ['shop']),
                new AdviseRequestSku('2', ['shop']),
                new AdviseRequestSku('3', ['shop']),
            ]
        );
    }

    public function testDefaultResponse()
    {
        $dist = [0 => 0.5, 1 => 1.0];
        $this->SUT->setDefaultCertainty($dist);

        $expected = new AdviseResponse(
            self::ADVISE_ID,
            AdviseResponse::STATUS_COMPLETE,
            1.0,
            [
                new AdviseResponseSku('1', $dist),
                new AdviseResponseSku('2', $dist),
                new AdviseResponseSku('3', $dist),
            ]
        );

        $this->assertEquals($expected, $this->SUT->createAdvise($this->request));
    }

    public function testDefaultError()
    {
        $err ='Not good';
        $this->SUT->setDefaultSkuError($err);

        $expected = new AdviseResponse(
            self::ADVISE_ID,
            AdviseResponse::STATUS_COMPLETE,
            1.0,
            [
                (new AdviseResponseSku('1', []))->setError($err),
                (new AdviseResponseSku('2', []))->setError($err),
                (new AdviseResponseSku('3', []))->setError($err),
            ]
        );

        $this->assertEquals($expected, $this->SUT->createAdvise($this->request));
    }

    public function testSpecificSkuResponse()
    {
        $dist = [0 => 0.5, 1 => 1.0];
        $err ='Not good';
        $this->SUT->setSkuSuccessResponse('1', $dist);
        $this->SUT->setSkuErrorResponse('2', $err);

        $expected = new AdviseResponse(
            self::ADVISE_ID,
            AdviseResponse::STATUS_COMPLETE,
            1.0,
            [
                new AdviseResponseSku('1', $dist),
                (new AdviseResponseSku('2', []))->setError($err),
                new AdviseResponseSku('3', [0 => 1.0]),
            ]
        );

        $this->assertEquals($expected, $this->SUT->createAdvise($this->request));
    }

    public function testMultipleRequests()
    {
        $this->SUT->setRequestsBeforeFinish(4);

        $expected = new AdviseResponse(self::ADVISE_ID, AdviseResponse::STATUS_PENDING, 0.25);
        $this->assertEquals($expected, $this->SUT->createAdvise($this->request));

        $expected = new AdviseResponse(self::ADVISE_ID, AdviseResponse::STATUS_PENDING, 0.5);
        $this->assertEquals($expected, $this->SUT->getAdvise(self::ADVISE_ID));

        $expected = new AdviseResponse(self::ADVISE_ID, AdviseResponse::STATUS_PENDING, 0.75);
        $this->assertEquals($expected, $this->SUT->getAdvise(self::ADVISE_ID));

        $expected = new AdviseResponse(
            self::ADVISE_ID,
            AdviseResponse::STATUS_COMPLETE,
            1.0,
            [
                new AdviseResponseSku('1', [0 => 1.0]),
                new AdviseResponseSku('2', [0 => 1.0]),
                new AdviseResponseSku('3', [0 => 1.0]),
            ]
        );

        $this->assertEquals($expected, $this->SUT->getAdvise(self::ADVISE_ID));
    }
}
