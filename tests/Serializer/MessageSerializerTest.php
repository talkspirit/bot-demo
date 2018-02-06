<?php

declare(strict_types=1);

namespace BotDemo\Tests\Message;

use BotDemo\DTO\Message;
use BotDemo\DTO\Room;
use BotDemo\DTO\User;
use BotDemo\Serializer\MessageSerializer;
use PHPUnit\Framework\TestCase;

class MessageSerializerTest extends TestCase
{
    /** @var MessageSerializer */
    private $messageSerializer;

    public function setUp()
    {
        $this->messageSerializer = new MessageSerializer();
    }

    public function testNormalize()
    {
        $room = new Room();
        $room->id = 'myRoomId';
        $message = new Message();
        $message->output = 'foo';
        $message->room = $room;
        $message->type = 'chat_message';
        $message->host = 'my.host.com';
        $message->token = 'myToken';

        $message = $this->messageSerializer->normalize($message);

        $expected = [
            'meta' => [
                'type' => 'chat_message',
            ],
            'data' => [
                'text' => 'foo',
                'room' => [
                    'id' => 'myRoomId',
                ],
            ],
        ];

        $this->assertEquals($expected, $message);
    }

    public function testDenormalize()
    {
        $payload = require (__DIR__ . '/../Mock/Data/ReceivedPayload.php');
        $message = $this->messageSerializer->denormalize($payload);

        $room = new Room();
        $room->id = 'myRoomId';

        $user = new User();
        $user->id = 'userSlug';
        $user->displayName = 'displayName';
        $user->type = 'user';

        $expected = new Message();
        $expected->token = 'myToken';
        $expected->host = 'myHost';
        $expected->type = 'chat_message';
        $expected->room = $room;
        $expected->user = $user;
        $expected->input = 'foo';

        $this->assertEquals($expected, $message);
    }
}
