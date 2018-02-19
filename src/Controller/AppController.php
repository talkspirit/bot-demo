<?php

declare(strict_types=1);

namespace Talkspirit\BotDemo\Controller;

use Talkspirit\BotDemo\Bot\BotInterface;
use Talkspirit\BotDemo\Bot\GoogleBot;
use Talkspirit\BotDemo\Bot\HelloWorldBot;
use Talkspirit\BotDemo\Client\HttpClient;
use Talkspirit\BotDemo\DTO\Message;
use Symfony\Component\HttpFoundation\Response;

class AppController
{
    public function helloWorldBot(HttpClient $client, HelloWorldBot $bot, Message $message = null)
    {
        return $this->botResponse($client, $bot, $message);
    }

    public function googleBot(HttpClient $client, GoogleBot $bot, Message $message = null)
    {
        return $this->botResponse($client, $bot, $message);
    }

    private function botResponse(HttpClient $client, BotInterface $bot, Message $message = null)
    {
        if($message === null) {
            return new Response('', Response::HTTP_NO_CONTENT);
        }

        $message = $bot->reply($message);

        $response = $client->prepareRequest($message);
        $client->sendRequest($response);

        return new Response('Response sent');
    }

    public function healthCheck()
    {
        return new Response('Welcome on the bot-demo app !');
    }
}
