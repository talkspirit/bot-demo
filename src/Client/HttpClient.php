<?php

declare(strict_types=1);

namespace Talkspirit\BotDemo\Client;

use Psr\Log\LoggerInterface;
use Talkspirit\BotDemo\DTO\InlineQuery;
use Talkspirit\BotDemo\DTO\Message;
use Talkspirit\BotDemo\Serializer\InlineQuerySerializer;
use Talkspirit\BotDemo\Serializer\MessageSerializer;
use GuzzleHttp\Client;
use Symfony\Component\HttpFoundation\Request;

class HttpClient
{
    /** @var Client */
    private $client;
    /** @var MessageSerializer */
    private $messageSerializer;
    /** @var InlineQuerySerializer */
    private $inlineQuerySerializer;
    /** @var string */
    private $domain;
    /** @var LoggerInterface */
    private $logger;

    public function __construct(
        Client $client,
        MessageSerializer $messageSerializer,
        InlineQuerySerializer $inlineQuerySerializer,
        string $domain,
        LoggerInterface $logger)
    {
        $this->client = $client;
        $this->messageSerializer = $messageSerializer;
        $this->inlineQuerySerializer = $inlineQuerySerializer;
        $this->domain = $domain;
        $this->logger = $logger;
    }

    public function prepareMessageRequest(Message $message): array
    {
        $url = sprintf('https://webhook.%s.net/v1/bot/%s', $this->domain, $message->token);
        $payload = $this->messageSerializer->normalize($message);

        $this->logPostRequest($url, json_encode($payload));

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

    public function prepareInlineQueryRequest(InlineQuery $inlineQuery)
    {
        $url = sprintf('https://webhook.%s.net/v1/bot/%s', $this->domain, $inlineQuery->token);
        $payload = $this->inlineQuerySerializer->normalize($inlineQuery);

        $this->logPostRequest($url, json_encode($payload));

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

    private function logPostRequest(string $url, string $payload)
    {
        $this->logger->info(sprintf('POST request sent to the url %s with payload : %s', $url, $payload));
    }
}
