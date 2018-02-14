<?php

namespace Talkspirit\BotDemo\Tests;

use Talkspirit\BotDemo\Client\HttpClient;
use Symfony\Bundle\FrameworkBundle\Client;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class IntegrationTest extends WebTestCase
{
    /** @var Client */
    private $client;

    protected function setUp()
    {
        $httpClient = $this->createMock(HttpClient::class);
        $httpClient->method('prepareRequest')->willReturn([]);

        $this->client = self::createClient();
        $this->client->getContainer()->set('test.' . HttpClient::class, $httpClient);
    }

    public function testAppPost()
    {
        $payload = require (__DIR__ . '/Mock/Data/ReceivedPayload.php');
        $jsonPayload = json_encode($payload);

        $this->client->request(Request::METHOD_POST, '/', [], [], [], $jsonPayload);
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
    }
}
