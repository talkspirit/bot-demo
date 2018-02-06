<?php

declare(strict_types=1);

namespace BotDemo\Client;

use BotDemo\DTO\Message;
use BotDemo\Serializer\MessageSerializer;
use GuzzleHttp\Client;
use Symfony\Component\HttpFoundation\Request;

class HttpClient
{
    /** @var Client */
    private $client;
    /** @var MessageSerializer */
    private $messageSerializer;
    /** @var string */
    private $domain;

    public function __construct(Client $client, MessageSerializer $messageSerializer, string $domain)
    {
        $this->client = $client;
        $this->messageSerializer = $messageSerializer;
        $this->domain = $domain;
    }

    public function prepareRequest(Message $message)
    {
        return [
            Request::METHOD_POST,
            sprintf('https://webhook.%s.net/v1/bot/%s', $this->domain, $message->token),
            [
                'headers' => [
                    'Accept'     => 'application/json',
                ],
                'json' => $this->messageSerializer->normalize($message)
            ],
        ];
    }

    public function sendRequest(array $request)
    {
        $this->client->request(...$request);
    }
}
