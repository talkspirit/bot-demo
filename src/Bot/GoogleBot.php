<?php

namespace Talkspirit\BotDemo\Bot;

use Symfony\Component\HttpFoundation\Request;
use Talkspirit\BotDemo\DTO\Message;
use GuzzleHttp\Client;

class GoogleBot implements BotInterface
{
    /** @var Client */
    private $client;
    /** @var string */
    private $serachEngine;
    /** @var string */
    private $googleApiKey;

    public function __construct(Client $client, string $searchEngine, string $gooleApiKey)
    {
        $this->client = $client;
        $this->googleApiKey = $gooleApiKey;
        $this->serachEngine = $searchEngine;
    }

    public function reply(Message $message): Message
    {
        $input = $message->input;

        if(preg_match('/^\/search (.*)/', $input, $matches)) {
            return $this->performSearch($message, $matches[1]);
        }

        $message->output = 'Hello search any word by typing "/search {word}"';

        return $message;
    }

    private function performSearch(Message $message, string $search): Message
    {
        $urlPattern = 'https://www.googleapis.com/customsearch/v1?key=%s&cx=%s&q=%s&alt=json&num=3';
        $url = sprintf($urlPattern, $this->googleApiKey, $this->serachEngine, $search);

        $response = $this->client->request(Request::METHOD_GET, $url, [
            'headers' => [
                'Accept'     => 'application/json',
            ],
        ]);
        $response = json_decode($response->getBody()->getContents(), true);


        $message->output = sprintf('## Searching for "%s"'. PHP_EOL, $search);
        foreach($response['items'] as $item) {
            $message->output .= sprintf('* [%s](%s)' . PHP_EOL, $item['title'], $item['link']);
        }

        return $message;
    }
}
