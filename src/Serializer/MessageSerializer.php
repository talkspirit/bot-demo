<?php

declare(strict_types=1);

namespace Talkspirit\BotDemo\Serializer;

use Talkspirit\BotDemo\DTO\Message;
use Talkspirit\BotDemo\DTO\Room;
use Talkspirit\BotDemo\DTO\User;

class MessageSerializer
{
    public function normalize(Message $message): array
    {
        $response = [
            'meta' => [
                'type' => $message->type,
            ],
            'data' => [
                'text' => $message->output,
                'room' => [
                    'id' => $message->room->id,
                ],
            ],
        ];

        if ($message->command) {
            $response['data']['command'] = $message->command;
        }

        return $response;
    }

    public function denormalize(array $payload): Message
    {
        $user = new User();
        $user->id = $payload['data']['from']['id'];
        $user->displayName = $payload['data']['from']['displayname'];
        $user->type = $payload['data']['from']['type'];

        $room = new Room();
        $room->id = $payload['data']['room']['id'];

        $message = new Message();

        $message->host = $payload['meta']['host'];
        $message->token = $payload['meta']['token'];
        $message->input = $payload['data']['text'];
        $message->id = $payload['data']['id'];
        $message->room = $room;
        $message->user = $user;

        if (isset($payload['data']['command'])) {
            $message->command = $payload['data']['command'];
        }

        return $message;
    }

    public function deserializeFromJson(string $payload): Message
    {
        return $this->denormalize(json_decode($payload, true));
    }

    public function serializeToJson(Message $message): string
    {
        return json_encode($this->normalize($message));
    }
}
