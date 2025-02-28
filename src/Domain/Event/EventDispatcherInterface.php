<?php

namespace Src\Domain\Event;

interface EventDispatcherInterface
{
    public function dispatch(object $event): void;
}
