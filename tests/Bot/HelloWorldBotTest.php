<?php

declare(strict_types=1);

namespace BotDemo\Tests\Bot;

use BotDemo\Bot\HelloWorldBot;
use BotDemo\DTO\Message;
use PHPUnit\Framework\TestCase;

class HelloWorldBotTest extends TestCase
{
    /** @var HelloWorldBot */
    private $helloWorldBot;

    protected function setUp()
    {
        $this->helloWorldBot = new HelloWorldBot();
    }

    public function testReply()
    {
        $message = new Message();
        $message->input = 'bar';

        $this->helloWorldBot->reply($message);

        $this->assertEquals('Hello World bar', $message->output);
    }
}
