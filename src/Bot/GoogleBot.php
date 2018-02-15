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
        $urlPattern = 'https://www.googleapis.com/customsearch/v1?key=%s&cx=%s&q=%s&alt=json&num=3';
        $url = sprintf($urlPattern, $this->googleApiKey, $this->serachEngine, $input);

        $response = $this->client->request(Request::METHOD_GET, $url, [
            'headers' => [
                'Accept'     => 'application/json',
            ],
        ]);
        $response = json_decode($response->getBody()->getContents(), true);

        $message->output .= '<ul>';
        foreach($response['items'] as $item) {
            $message->output .= '<h2><a href="' . $item['link'] . '">' . $item['title'] . '</a></h2>';
        }
        $message->output .= '</ul>';

        return $message;
    }
}
