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
    /** @var GoogleBot */
    private $googleBot;
    /** @var Client */
    private $client;
    /** @var Response */
    private $response;

    public function setUp()
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

        $this->response = $this->createMock(Response::class);
        $this->response->method('getBody')->willReturn($stream);

        $this->client = $this->createMock(Client::class);

        $this->googleBot = new GoogleBot($this->client, 'foo', 'bar');
    }

    public function testSimpleReply()
    {
        $message = new Message();
        $message->input = 'bar';

        $this->googleBot->reply($message);

        $this->assertEquals('Hello search any word by typing "/search {word}"', $message->output);
    }

    public function testReply()
    {
        $message = new Message();
        $message->input = '/search bar foo';

        $this->client->method('request')->with(
            'GET',
            'https://www.googleapis.com/customsearch/v1?key=bar&cx=foo&q=bar foo&alt=json&num=3',
            ['headers' => [
                'Accept'     => 'application/json',
            ]]
        )->willReturn($this->response);

        $this->googleBot->reply($message);

        $this->assertEquals('## Searching for "bar foo"' . PHP_EOL . '* [title1](http://title1.com)' . PHP_EOL . '* [title2](http://title2.com)' . PHP_EOL, $message->output);
    }
}
