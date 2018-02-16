<?php

namespace Talkspirit\BotDemo\Tests;

use Talkspirit\BotDemo\Client\HttpClient;
use Symfony\Bundle\FrameworkBundle\Client;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;

class IntegrationTest extends WebTestCase
{
    /** @var Client */
    private $client;
    /** @var string */
    private $jsonPayload;

    protected function setUp()
    {
        $httpClient = $this->createMock(HttpClient::class);
        $httpClient->method('prepareRequest')->willReturn([]);

        $this->client = self::createClient();
        $this->client->getContainer()->set('test.' . HttpClient::class, $httpClient);

        $payload = require (__DIR__ . '/Mock/Data/ReceivedPayload.php');
        $this->jsonPayload = json_encode($payload);
    }

    public function testAppPost()
    {
        $payload = require (__DIR__ . '/Mock/Data/ReceivedPayload.php');
        $jsonPayload = json_encode($payload);

        $this->client->request(Request::METHOD_POST, '/helloworld-bot', [], [], [], $jsonPayload);
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
    }
}
