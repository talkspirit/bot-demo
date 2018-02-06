<?php

declare(strict_types=1);

namespace BotDemo\Tests\Controller;

use BotDemo\Bot\HelloWorldBot;
use BotDemo\Client\HttpClient;
use BotDemo\Controller\AppController;
use BotDemo\DTO\Message;
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

    public function testIndexAction()
    {
        $message = new Message();
        $request = new Request();
        $request->query->set('message', $message);
        $client = $this->createMock(HttpClient::class);
        $client->method('prepareRequest')->willReturn(['request']);
        $bot = $this->createMock(HelloWorldBot::class);

        $bot->expects($this->once())->method('reply')->with($this->equalTo($message));
        $client->expects($this->once())->method('prepareRequest');
        $client->expects($this->once())->method('sendRequest')->with($this->equalTo(['request']));

        $this->controller->index($request, $client, $bot);
    }
}
