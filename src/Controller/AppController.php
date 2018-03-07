<?php

declare(strict_types=1);

namespace Talkspirit\BotDemo\Controller;

use Talkspirit\BotDemo\Bot\BotInterface;
use Talkspirit\BotDemo\Bot\GoogleBot;
use Talkspirit\BotDemo\Bot\HelloWorldBot;
use Talkspirit\BotDemo\Client\HttpClient;
use Talkspirit\BotDemo\DTO\InlineQuery;
use Talkspirit\BotDemo\DTO\Message;
use Symfony\Component\HttpFoundation\Response;

class AppController
{
    public function helloWorldBot(HttpClient $client, HelloWorldBot $bot, Message $message)
    {
        return $this->botResponse($client, $bot, $message);
    }

    public function googleBot(HttpClient $client, GoogleBot $bot, Message $message)
    {
        return $this->botResponse($client, $bot, $message);
    }

    private function botResponse(HttpClient $client, BotInterface $bot, Message $message)
    {
        if (empty($message->input)) {
            $inlineQuery = new InlineQuery();
            $inlineQuery->token = $message->token;
            $inlineQuery->id = $message->id;
            $inlineQuery->commands = $bot->getAvailableCommands();
            $response = $client->prepareInlineQueryRequest($inlineQuery);
        } else {
            $message = $bot->reply($message);
            $response = $client->prepareMessageRequest($message);
        }

        $client->sendRequest($response);

        return new Response('Response sent');
    }

    public function healthCheck()
    {
        return new Response('Welcome on the bot-demo app !');
    }
}
