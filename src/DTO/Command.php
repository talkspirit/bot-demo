<?php

declare(strict_types=1);

namespace Talkspirit\BotDemo\DTO;

class Command
{
    /** @var string */
    public $title;
    /** @var string|null */
    public $description;
    /** @var string|null */
    public $trigger;
    /** @var string|null */
    public $usage;

    public static function createCommand(string $title, string $description, string $trigger, string $usage): self
    {
        $self = new self();
        $self->title = $title;
        $self->description = $description;
        $self->trigger = $trigger;
        $self->usage = $usage;

        return $self;
    }

    public function toArray(): array
    {
        return [
            'type' => 'command',
            'title' => $this->title,
            'description' => $this->description,
            'trigger' => $this->trigger,
            'usage' => $this->usage,
        ];
    }
}
