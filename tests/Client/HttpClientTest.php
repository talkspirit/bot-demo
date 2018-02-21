<?php

declare(strict_types=1);

namespace Talkspirit\BotDemo\Tests\Message;

use Psr\Log\LoggerInterface;
use Talkspirit\BotDemo\Client\HttpClient;
use Talkspirit\BotDemo\DTO\InlineQuery;
use Talkspirit\BotDemo\DTO\Message;
use Talkspirit\BotDemo\Serializer\InlineQuerySerializer;
use Talkspirit\BotDemo\Serializer\MessageSerializer;
use PHPUnit\Framework\TestCase;
use GuzzleHttp\Client;

class HttpClientTest extends TestCase
{
    /** @var HttpClient */
    private $httpClient;

    public function setUp()
    {
        $client = $this->createMock(Client::class);
        $messageSerializer = $this->createMock(MessageSerializer::class);
        $messageSerializer->method('normalize')->willReturn(['normalizedMessage']);

        $inlineQuerySerializer = $this->createMock(InlineQuerySerializer::class);
        $inlineQuerySerializer->method('normalize')->willReturn(['normalizedInlineQuery']);

        $this->httpClient = new HttpClient(
            $client,
            $messageSerializer,
            $inlineQuerySerializer,
            'myDomain',
            $this->createMock(LoggerInterface::class)
        );
    }

    public function testPrepareMessageRequest()
    {
        $message = new Message();
        $message->token = 'mytoken';
        $request = $this->httpClient->prepareMessageRequest($message);

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

    public function testPrepareInlineQueryRequest()
    {
        $inlineQuery = new InlineQuery();
        $inlineQuery->token = 'mytoken';
        $request = $this->httpClient->prepareInlineQueryRequest($inlineQuery);

        $expected = [
            'POST',
            'https://webhook.myDomain.net/v1/bot/mytoken',
            [
                'headers' => [
                    'Accept'     => 'application/json',
                ],
                'json' => ['normalizedInlineQuery']
            ],
        ];

        $this->assertEquals($expected, $request);
    }
}
