<?php

declare(strict_types=1);

namespace Talkspirit\BotDemo\DTO;

class User
{
    const TYPE_USER = 'user';
    const TYPE_BOT = 'bot';

    /** @var string */
    public $id;
    /** @var string */
    public $displayName;
    /** @var string */
    public $type;

    public function isBot()
    {
        return $this->type === self::TYPE_BOT;
    }
}
