<?php

namespace Talkspirit\BotDemo\Bot;

use Talkspirit\BotDemo\DTO\Message;

interface BotInterface
{
    /**
     * Reply to a given message.
     */
    public function reply(Message $message) : Message;
}
