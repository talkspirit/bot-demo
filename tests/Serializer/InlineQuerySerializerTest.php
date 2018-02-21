<?php

namespace Talkspirit\BotDemo\Tests\Serializer;

use PHPUnit\Framework\TestCase;
use Talkspirit\BotDemo\DTO\Command;
use Talkspirit\BotDemo\DTO\InlineQuery;
use Talkspirit\BotDemo\Serializer\InlineQuerySerializer;

class InlineQuerySerializerTest extends TestCase
{
    /** @var InlineQuerySerializer */
    private $inlineQuerySerializer;

    public function setUp()
    {
        $this->inlineQuerySerializer = new InlineQuerySerializer();
    }

    public function testNormalize()
    {
        $command = new Command();
        $command->title = 'myTitle';
        $command->description = 'myDesc';
        $command->trigger = 'myTrigger';
        $command->usage = 'myUsage';
        $inlineQuery = new InlineQuery();
        $inlineQuery->id = 'myId';
        $inlineQuery->commands = [$command];

        $message = $this->inlineQuerySerializer->normalize($inlineQuery);

        $expected = [
            'meta' => [
                'type' => 'inline_query',
            ],
            'data' => [
                'id' => 'myId',
                'result' => [
                    [
                        'type' => 'command',
                        'title' => 'myTitle',
                        'description' => 'myDesc',
                        'trigger' => 'myTrigger',
                        'usage' => 'myUsage',
                    ]
                ],
            ],
        ];

        $this->assertEquals($expected, $message);
    }
}
