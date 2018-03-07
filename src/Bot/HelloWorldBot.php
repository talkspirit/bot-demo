<?php

declare(strict_types=1);

namespace Talkspirit\BotDemo\Bot;

use Talkspirit\BotDemo\DTO\Command;
use Talkspirit\BotDemo\DTO\Message;

class HelloWorldBot implements BotInterface
{
    const HELP_MESSAGE = 'To use this bot just type any word !';

    public function reply(Message $message): Message
    {
        $input = $message->input;

        if (preg_match('/^\/help/', $input, $matches)) {
            return $this->getHelp($message);
        }

        $message->output = 'Hello World '.$message->input;

        return $message;
    }

    private function getHelp(Message $message) : Message
    {
        $message->output = self::HELP_MESSAGE;

        return $message;
    }

    public function getAvailableCommands(): array
    {
        return [
            Command::createCommand('Help', 'Get the help', '/help', '/help')
        ];
    }
}
