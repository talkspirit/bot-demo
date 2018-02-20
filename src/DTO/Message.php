<?php

declare(strict_types=1);

namespace Talkspirit\BotDemo\DTO;

class Message
{
    /** @var string */
    public $token;
    /** @var string */
    public $host;
    /** @var string */
    public $type;
    /** @var string */
    public $output;
    /** @var string */
    public $input;
    /** @var Room */
    public $room;
    /** @var User */
    public $user;
    /** @var string */
    public $command;
}
