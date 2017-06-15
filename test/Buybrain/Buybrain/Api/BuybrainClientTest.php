<?php
namespace Buybrain\Buybrain\Api;

use Buybrain\Buybrain\Api\Message\AdviseResponse;
use Buybrain\Buybrain\Api\Message\AdviseSku;
use Buybrain\Buybrain\Api\Message\CreateAdviseRequest;
use Buybrain\Buybrain\Util\DateTimes;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Psr7\Response;
use PHPUnit_Framework_MockObject_MockObject;
use PHPUnit_Framework_TestCase;
use function GuzzleHttp\Psr7\stream_for;

class BuybrainClientTest extends PHPUnit_Framework_TestCase
{
    const ADVISE_ID = '00000000-0000-0000-0000-000000000000';
    const API_KEY = 'testkey';

    /** @var ClientInterface|PHPUnit_Framework_MockObject_MockObject */
    private $http;
    /** @var BuybrainClient */
    private $SUT;

    public function setUp()
    {
        $this->http = $this->createMock(ClientInterface::class);
        $this->SUT = new BuybrainClient(new BuybrainClientConfig(self::API_KEY), $this->http);
    }
    
    public function testCreateAdvise()
    {
        $request = new CreateAdviseRequest(
            DateTimes::parse('2017-01-01'),
            DateTimes::parse('2017-01-05'),
            true,
            [
                'shop' => ['1', '2'],
                'ebay' => ['1', '3']
            ]
        );

        $response = new AdviseResponse(
            self::ADVISE_ID,
            AdviseResponse::STATUS_PENDING,
            0.42
        );

        $this->http->expects($this->once())
            ->method('request')
            ->with(
                'POST',
                'https://api.buybrain.io/advise',
                [
                    'headers' => [
                        'Accept' => 'application/json',
                        'Apikey' => self::API_KEY
                    ],
                    'timeout' => BuybrainClient::TIMEOUT,
                    'json' => $request
                ]
            )
            ->willReturn((new Response())->withBody(stream_for(json_encode($response))));

        $result = $this->SUT->createAdvise($request);

        $expected = $response;

        $this->assertEquals($expected, $result);
    }
    
    public function testGetAdvise()
    {
        $response = new AdviseResponse(
            self::ADVISE_ID,
            AdviseResponse::STATUS_COMPLETE,
            1.0,
            [
                new AdviseSku('1', ['0' => 0.8, '1' => 0.2]),
                new AdviseSku('2', ['0' => 0.7, '1' => 0.2, '2' => 0.1]),
                new AdviseSku('3', ['0' => 0.9, '1' => 0.1])
            ]
        );

        $this->http->expects($this->once())
            ->method('request')
            ->with(
                'GET',
                $this->stringEndsWith( '/advise/' . self::ADVISE_ID),
                $this->anything()
            )
            ->willReturn((new Response())->withBody(stream_for(json_encode($response))));

        $result = $this->SUT->getAdvise(self::ADVISE_ID);

        $expected = $response;

        $this->assertEquals($expected, $result);
    }
}