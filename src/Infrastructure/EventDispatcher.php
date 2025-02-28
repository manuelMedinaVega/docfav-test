<?php

namespace Src\Infrastructure;

use Src\Domain\Event\EventDispatcherInterface;
use Src\Domain\Event\UserRegisteredEvent;
use Src\Infrastructure\Event\UserRegisteredEventHandler;

final class EventDispatcher implements EventDispatcherInterface
{
    private array $handlers = [];

    public function __construct()
    {
        $this->handlers[UserRegisteredEvent::class] = new UserRegisteredEventHandler;
    }

    public function dispatch(object $event): void
    {
        $eventClass = get_class($event);
        if (isset($this->handlers[$eventClass])) {
            $this->handlers[$eventClass]->handle($event);
        }
    }
}
