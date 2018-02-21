<?php

declare(strict_types=1);

namespace Talkspirit\BotDemo\DTO;

class InlineQuery
{
    /** @var string */
    public $id;
    /** @var string */
    public $token;
    /** @var Command[] */
    public $commands = [];
}
