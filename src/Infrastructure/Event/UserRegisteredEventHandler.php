<?php

namespace Src\Infrastructure\Event;

use Src\Application\EventListener\UserRegisteredListener;
use Src\Domain\Event\UserRegisteredEvent;

final class UserRegisteredEventHandler
{
    private UserRegisteredListener $listener;

    public function __construct()
    {
        $this->listener = new UserRegisteredListener;
    }

    public function handle(UserRegisteredEvent $event): void
    {
        $this->listener->handle($event);
    }
}
