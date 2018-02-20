<?php

declare(strict_types=1);

namespace Talkspirit\BotDemo\Tests\EventListener;

use Psr\Log\LoggerInterface;
use Talkspirit\BotDemo\DTO\Message;
use Talkspirit\BotDemo\DTO\User;
use Talkspirit\BotDemo\EventListener\RequestListener;
use Talkspirit\BotDemo\Serializer\MessageSerializer;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;

class RequestListenerTest extends TestCase
{
    public function testOnKernelRequest()
    {
        $fakeMessage = new Message();
        $fakeMessage->output = 'fooBar';
        $fakeMessage->user = new User();
        $fakeMessage->user->type = User::TYPE_USER;
        $jsonContent = 'jsonContent';
        $request = Request::create('/', Request::METHOD_POST, [], [], [], [], $jsonContent);
        $request->setMethod(Request::METHOD_POST);

        $event = $this->createMock(GetResponseEvent::class);
        $event->method('getRequest')
            ->willReturn($request);

        $messageSerializer = $this->createMock(MessageSerializer::class);
        $messageSerializer->expects($this->once())
            ->method('deserializeFromJson')
            ->willReturn($fakeMessage)
            ->with($this->equalTo('jsonContent'));

        $requestListener = new RequestListener($messageSerializer, $this->createMock(LoggerInterface::class));

        $requestListener->onKernelRequest($event);

        $this->assertEquals($request->get('message'), $fakeMessage);
    }
}
