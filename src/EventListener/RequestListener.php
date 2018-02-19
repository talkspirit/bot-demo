<?php

declare(strict_types=1);

namespace Talkspirit\BotDemo\EventListener;

use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Talkspirit\BotDemo\Serializer\MessageSerializer;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;

class RequestListener
{
    /** @var MessageSerializer */
    protected $messageSerializer;

    public function __construct(MessageSerializer $messageSerializer)
    {
        $this->messageSerializer = $messageSerializer;
    }

    public function onKernelRequest(GetResponseEvent $event)
    {
        $request = $event->getRequest();

        if ($request->getMethod() === Request::METHOD_POST) {
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
