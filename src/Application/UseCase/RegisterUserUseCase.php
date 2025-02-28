<?php

namespace Src\Application\UseCase;

use Src\Application\DTO\RegisterUserRequest;
use Src\Application\DTO\UserResponseDTO;
use Src\Domain\Entity\User;
use Src\Domain\Event\EventDispatcherInterface;
use Src\Domain\Event\UserRegisteredEvent;
use Src\Domain\Repository\UserRepositoryInterface;
use Src\Domain\ValueObject\Email;
use Src\Domain\ValueObject\Name;
use Src\Domain\ValueObject\Password;
use Src\Domain\ValueObject\UserId;
use Src\Presentation\Exception\EmailAlreadyInUseException;
use Src\Presentation\Exception\UserAlreadyExistsException;

class RegisterUserUseCase
{
    private UserRepositoryInterface $userRepository;

    private EventDispatcherInterface $eventDispatcher;

    public function __construct(UserRepositoryInterface $userRepository, EventDispatcherInterface $eventDispatcher)
    {
        $this->userRepository = $userRepository;
        $this->eventDispatcher = $eventDispatcher;
    }

    public function execute(RegisterUserRequest $request): UserResponseDTO
    {
        if ($this->userRepository->findById(new UserId($request->getId()))) {
            throw new UserAlreadyExistsException;
        }

        if ($this->userRepository->findByEmail(new Email($request->getEmail()))) {
            throw new EmailAlreadyInUseException;
        }

        $user = new User(
            new UserId($request->getId()),
            new Name($request->getName()),
            new Email($request->getEmail()),
            new Password($request->getPassword())
        );

        $this->userRepository->save($user);

        $event = new UserRegisteredEvent($user->getId(), $user->getEmail());
        $this->eventDispatcher->dispatch($event);

        return new UserResponseDTO(
            $user->getId()->value(),
            $user->getName()->value(),
            $user->getEmail()->value(),
            $user->getCreatedAt()->format('Y-m-d H:i:s')
        );
    }
}
