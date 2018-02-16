<?php

declare(strict_types=1);

namespace Talkspirit\BotDemo\Bot;

use Talkspirit\BotDemo\DTO\Message;

class HelloWorldBot implements BotInterface
{
    public function reply(Message $message): Message
    {
        $message->output = 'Hello World '.$message->input;

        return $message;
    }
}
