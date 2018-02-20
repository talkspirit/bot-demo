<?php

declare(strict_types=1);

namespace Talkspirit\BotDemo\Client;

use Psr\Log\LoggerInterface;
use Talkspirit\BotDemo\DTO\Message;
use Talkspirit\BotDemo\Serializer\MessageSerializer;
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
    /** @var LoggerInterface */
    private $logger;

    public function __construct(Client $client, MessageSerializer $messageSerializer, string $domain, LoggerInterface $logger)
    {
        $this->client = $client;
        $this->messageSerializer = $messageSerializer;
        $this->domain = $domain;
        $this->logger = $logger;
    }

    public function prepareRequest(Message $message)
    {
        $url = sprintf('https://webhook.%s.net/v1/bot/%s', $this->domain, $message->token);
        $payload = $this->messageSerializer->normalize($message);

        $this->logger->info(sprintf('POST request sent to the url %s with payload : %s', $url, json_encode($payload)));

        return [
            Request::METHOD_POST,
            $url,
            [
                'headers' => [
                    'Accept' => 'application/json',
                ],
                'json' => $payload,
            ],
        ];
    }

    public function sendRequest(array $request)
    {
        $this->client->request(...$request);
    }
}
