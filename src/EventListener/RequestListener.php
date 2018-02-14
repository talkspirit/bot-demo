<?php

declare(strict_types=1);

namespace Talkspirit\BotDemo\EventListener;

use Talkspirit\BotDemo\Serializer\MessageSerializer;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;

class RequestListener
{
    const REQUEST_MESSAGE_KEY = 'message';

    /** @var MessageSerializer */
    protected $messageSerializer;

    public function __construct(MessageSerializer $messageSerializer)
    {
        $this->messageSerializer = $messageSerializer;
    }

    public function onKernelRequest(GetResponseEvent $event)
    {
        $request = $event->getRequest();

        if ($request->getMethod() === Request::METHOD_POST && $request->getRequestUri() === '/') {
            $message = $this->messageSerializer->deserializeFromJson($request->getContent());

            if (!$message->user->isBot()) {
                $request->query->set(self::REQUEST_MESSAGE_KEY, $message);
            }
        }
    }
}
