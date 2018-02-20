<?php

declare(strict_types=1);

namespace Talkspirit\BotDemo\EventListener;

use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Talkspirit\BotDemo\Serializer\MessageSerializer;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;

class RequestListener
{
    /** @var MessageSerializer */
    private $messageSerializer;
    /** @var LoggerInterface */
    private $logger;

    public function __construct(MessageSerializer $messageSerializer, LoggerInterface $logger)
    {
        $this->messageSerializer = $messageSerializer;
        $this->logger = $logger;
    }

    public function onKernelRequest(GetResponseEvent $event)
    {
        $request = $event->getRequest();

        if (Request::METHOD_POST === $request->getMethod()) {
            $this->logger->info('POST request received with payload : ' . $request->getContent());

            if(empty($request->getContent())) {
                throw new BadRequestHttpException('Invalid message');
            }

            $message = $this->messageSerializer->deserializeFromJson($request->getContent());

            if (!$message->user->isBot()) {
                $request->attributes->set('message', $message);
            }
        }
    }
}
