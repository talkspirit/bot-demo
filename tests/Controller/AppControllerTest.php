<?php

declare(strict_types=1);

namespace Talkspirit\BotDemo\Tests\Controller;

use Talkspirit\BotDemo\Bot\BotInterface;
use Talkspirit\BotDemo\Bot\HelloWorldBot;
use Talkspirit\BotDemo\Client\HttpClient;
use Talkspirit\BotDemo\Controller\AppController;
use Talkspirit\BotDemo\DTO\InlineQuery;
use Talkspirit\BotDemo\DTO\Message;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;

class AppControllerTest extends TestCase
{
    /** @var AppController */
    private $controller;

    protected function setUp()
    {
        $this->controller = new AppController();
    }

    public function testHelloWorld()
    {
        $message = new Message();
        $message->input = 'foo';
        $client = $this->createMock(HttpClient::class);
        $client->method('prepareMessageRequest')->willReturn(['request']);
        $bot = $this->createMock(HelloWorldBot::class);

        $bot->expects($this->once())->method('reply')->with($this->equalTo($message));
        $client->expects($this->once())->method('prepareMessageRequest');
        $client->expects($this->once())->method('sendRequest')->with($this->equalTo(['request']));

        $this->controller->helloWorldBot($client, $bot, $message);
    }

    public function testHelloWorldInlineQuery()
    {
        $message = new Message();
        $message->id = 'myId';
        $message->token = 'myToken';
        $message->input = '';
        $client = $this->createMock(HttpClient::class);
        $client->method('prepareInlineQueryRequest')->willReturn(['request']);
        $bot = $this->createMock(HelloWorldBot::class);

        $expectedInlineQuery = new InlineQuery();
        $expectedInlineQuery->id = 'myId';
        $expectedInlineQuery->token = 'myToken';

        $bot->expects($this->once())->method('getAvailableCommands');
        $client->expects($this->once())->method('prepareInlineQueryRequest')->with($this->equalTo($expectedInlineQuery));
        $client->expects($this->once())->method('sendRequest')->with($this->equalTo(['request']));

        $this->controller->helloWorldBot($client, $bot, $message);
    }
}
