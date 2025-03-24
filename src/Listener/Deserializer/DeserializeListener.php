<?php

declare(strict_types=1);

namespace App\Listener\Deserializer;

use ApiPlatform\Symfony\EventListener\DeserializeListener as DecoratedDeserializeListener;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\RequestEvent;

class DeserializeListener
{
    public function __construct(private readonly DecoratedDeserializeListener $listener)
    {
    }

    public function onKernelRequest(RequestEvent $event): void
    {
        $request = $event->getRequest();

        if ($request->isMethodCacheable() || $request->isMethod(Request::METHOD_DELETE)) {
            return;
        }

    }
}
