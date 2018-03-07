<?php

declare(strict_types=1);

namespace Talkspirit\BotDemo\Serializer;

use Talkspirit\BotDemo\DTO\Command;
use Talkspirit\BotDemo\DTO\InlineQuery;

class InlineQuerySerializer
{
    public function normalize(InlineQuery $inlineQuery): array
    {
        return [
            'meta' => [
                'type' => 'inline_query',
            ],
            'data' => [
                'id' => $inlineQuery->id,
                'result' => array_map(function (Command $command) {
                    return $command->toArray();
                }, $inlineQuery->commands),
            ],
        ];
    }

    public function serializeToJson(InlineQuery $inlineQuery): string
    {
        return json_encode($this->normalize($inlineQuery));
    }
}
