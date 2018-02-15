<?php

namespace Talkspirit\BotDemo\Tests\Bot;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\Stream;
use PHPUnit\Framework\TestCase;
use Talkspirit\BotDemo\Bot\GoogleBot;
use Talkspirit\BotDemo\DTO\Message;

class GoogleBotTest extends TestCase
{
    public function testReply()
    {
        $payload = [
            'items' => [
                [
                    'title' => 'title1',
                    'link' => 'http://title1.com'
                ],
                [
                    'title' => 'title2',
                    'link' => 'http://title2.com'
                ],
            ]
        ];
        $stream = $this->createMock(Stream::class);
        $stream->method('getContents')->willReturn(json_encode($payload));

        $response = $this->createMock(Response::class);
        $response->method('getBody')->willReturn($stream);

        $client = $this->createMock(Client::class);
        $client->method('request')->willReturn($response);

        $message = new Message();
        $message->input = 'bar';

        $googleBot = new GoogleBot($client, 'foo', 'bar');
        $googleBot->reply($message);

        $this->assertEquals('<ul><li><h2><a href="http://title1.com">title1</a></h2></li><li><h2><a href="http://title2.com">title2</a></h2></li></ul>', $message->output);
    }
}
