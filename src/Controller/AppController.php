<?php

declare(strict_types=1);

namespace Talkspirit\BotDemo\Controller;

use Talkspirit\BotDemo\Bot\BotInterface;
use Talkspirit\BotDemo\Bot\GoogleBot;
use Talkspirit\BotDemo\Bot\HelloWorldBot;
use Talkspirit\BotDemo\Client\HttpClient;
use Talkspirit\BotDemo\EventListener\RequestListener;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AppController
{
    public function helloWorldBot(Request $request, HttpClient $client, HelloWorldBot $bot)
    {
        return $this->botResponse($request, $client, $bot);
    }

    public function googleBot(Request $request, HttpClient $client, GoogleBot $bot)
    {
        if($request->getMethod() === Request::METHOD_GET) {
            return new Response('Welcome on the google bot !');
        }

        return $this->botResponse($request, $client, $bot);
    }

    private function botResponse(Request $request, HttpClient $client, BotInterface $bot)
    {
        if($request->get(RequestListener::REQUEST_MESSAGE_KEY) === null) {
            return new Response(null, Response::HTTP_NO_CONTENT);
        }

        $message = $request->get(RequestListener::REQUEST_MESSAGE_KEY);
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
