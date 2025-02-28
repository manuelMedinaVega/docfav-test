<?php

namespace Src\Application\EventListener;

use Src\Domain\Event\UserRegisteredEvent;

final class UserRegisteredListener
{
    public function handle(UserRegisteredEvent $event): void
    {
        $message = sprintf(
            "📩 Enviando email de bienvenida a %s\nEvento ocurrido en: %s",
            $event->getEmail()->value(),
            $event->getOccurredOn()->format('Y-m-d H:i:s')
        );
        error_log($message, 3, __DIR__.'/../../storage/logs/event.log');
    }
}
