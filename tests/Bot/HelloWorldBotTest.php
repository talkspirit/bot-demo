<?php

declare(strict_types=1);

namespace Talkspirit\BotDemo\Tests\Bot;

use Talkspirit\BotDemo\Bot\HelloWorldBot;
use Talkspirit\BotDemo\DTO\Message;
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

    public function testHelpCommand()
    {
        $message = new Message();
        $message->input = '/help';

        $this->helloWorldBot->reply($message);

        $this->assertEquals(HelloWorldBot::HELP_MESSAGE, $message->output);
    }
}
