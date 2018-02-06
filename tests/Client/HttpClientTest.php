<?php

declare(strict_types=1);

namespace BotDemo\Tests\Message;

use BotDemo\Client\HttpClient;
use BotDemo\DTO\Message;
use BotDemo\Serializer\MessageSerializer;
use PHPUnit\Framework\TestCase;
use GuzzleHttp\Client;

class HttpClientTest extends TestCase
{
    /** @var HttpClient */
    private $httpClient;

    public function setUp()
    {
        $client = $this->createMock(Client::class);
        $serializer = $this->createMock(MessageSerializer::class);
        $serializer->method('normalize')->willReturn(['normalizedMessage']);

        $this->httpClient = new HttpClient($client, $serializer, 'myDomain');
    }

    public function testPrepareRequest()
    {
        $message = new Message();
        $message->token = 'mytoken';
        $request = $this->httpClient->prepareRequest($message);

        $expected = [
            'POST',
            'https://webhook.myDomain.net/v1/bot/mytoken',
            [
                'headers' => [
                    'Accept'     => 'application/json',
                ],
                'json' => ['normalizedMessage']
            ],
        ];

        $this->assertEquals($expected, $request);
    }
}
