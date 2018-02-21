<?php

namespace Talkspirit\BotDemo\Tests;

use Talkspirit\BotDemo\Client\HttpClient;
use Symfony\Bundle\FrameworkBundle\Client;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;
use Talkspirit\BotDemo\DTO\User;

class IntegrationTest extends WebTestCase
{
    /** @var Client */
    private $client;
    /** @var HttpClient */
    private $httpClient;

    protected function setUp()
    {
        $this->httpClient = $this->createMock(HttpClient::class);
        $this->httpClient->method('prepareMessageRequest')->willReturn([]);
        $this->httpClient->method('prepareInlineQueryRequest')->willReturn([]);

        $this->client = self::createClient();
        $this->client->getContainer()->set('test.' . HttpClient::class, $this->httpClient);
    }

    public function testAppPost()
    {
        $payload = require (__DIR__ . '/Mock/Data/ReceivedPayload.php');
        $jsonPayload = json_encode($payload);

        $this->httpClient->expects($this->once())->method('prepareMessageRequest');

        $this->client->request(Request::METHOD_POST, '/helloworld-bot', [], [], [], $jsonPayload);
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
    }

    public function testAppBotResponsePost()
    {
        $payload = require (__DIR__ . '/Mock/Data/ReceivedPayload.php');
        $payload['data']['from']['type'] = User::TYPE_BOT;
        $jsonPayload = json_encode($payload);

        $this->client->request(Request::METHOD_POST, '/helloworld-bot', [], [], [], $jsonPayload);
        $this->assertEquals(204, $this->client->getResponse()->getStatusCode());
    }

    public function testAppEmptyPost()
    {
        $this->client->request(Request::METHOD_POST, '/helloworld-bot', [], [], [], '');
        $this->assertEquals(400, $this->client->getResponse()->getStatusCode());
    }
}
