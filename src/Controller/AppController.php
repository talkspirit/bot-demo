<?php

declare(strict_types=1);

namespace BotDemo\Controller;

use BotDemo\Bot\HelloWorldBot;
use BotDemo\Client\HttpClient;
use BotDemo\EventListener\RequestListener;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AppController
{
    /**
     * @Route("/", methods={"POST"})
     */
    public function index(Request $request, HttpClient $client, HelloWorldBot $bot)
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

    /**
     * @Route("/", methods={"GET"})
     */
    public function healthCheck()
    {
        return new Response('Welcome on the bot-demo app !');
    }
}
