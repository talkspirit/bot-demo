<?php

namespace Talkspirit\BotDemo\Bot;

use Talkspirit\BotDemo\DTO\Message;

interface BotInterface
{
    /**
     * Reply to a given message.
     */
    public function reply(Message $message): Message;

    /**
     * Return the list of the available command for the bot.
     */
    public function getAvailableCommands(): array;
}
