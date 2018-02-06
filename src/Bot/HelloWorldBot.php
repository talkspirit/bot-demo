<?php

declare(strict_types=1);

namespace BotDemo\Bot;

use BotDemo\DTO\Message;

class HelloWorldBot
{
    public function reply(Message $message) : Message
    {
        $message->output = 'Hello World ' . $message->input;

        return $message;
    }
}
