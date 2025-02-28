<?php

declare(strict_types=1);

use Faker\Factory;
use PHPUnit\Framework\TestCase;
use Src\Application\DTO\RegisterUserRequest;
use Src\Application\DTO\UserResponseDTO;
use Src\Application\UseCase\RegisterUserUseCase;
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

final class RegisterUserUseCaseTest extends TestCase
{
    private $faker;

    private $repositoryMock;

    private $dispatcherMock;

    protected function setUp(): void
    {
        $this->faker = Factory::create('es_ES');
        $this->repositoryMock = $this->createMock(UserRepositoryInterface::class);
        $this->dispatcherMock = $this->createMock(EventDispatcherInterface::class);
    }

    private function createRegisterUserRequest(?string $id = null, ?string $email = null): RegisterUserRequest
    {
        return new RegisterUserRequest(
            $id ?? $this->faker->uuid(),
            $this->faker->firstName().' '.$this->faker->lastName(),
            $email ?? $this->faker->unique()->safeEmail(),
            $this->faker->password(8, 16).'A@1'
        );
    }

    private function createUser(): User
    {
        return new User(
            new UserId($this->faker->uuid()),
            new Name($this->faker->firstName().' '.$this->faker->lastName()),
            new Email($this->faker->unique()->safeEmail()),
            new Password($this->faker->password(8, 16).'A@1')
        );
    }

    public function test_user_registration(): void
    {
        $this->repositoryMock->expects($this->once())->method('save');

        $useCase = new RegisterUserUseCase($this->repositoryMock, $this->dispatcherMock);
        $request = $this->createRegisterUserRequest();

        $user = $useCase->execute($request);

        $this->assertInstanceOf(UserResponseDTO::class, $user);
        $this->assertSame($request->getId(), $user->getId());
        $this->assertSame($request->getName(), $user->getName());
        $this->assertSame($request->getEmail(), $user->getEmail());
    }

    public function test_register_user_dispatches_event(): void
    {
        $this->repositoryMock->method('findById')->willReturn(null);
        $this->dispatcherMock->expects($this->once())->method('dispatch')->with($this->isInstanceOf(UserRegisteredEvent::class));

        $useCase = new RegisterUserUseCase($this->repositoryMock, $this->dispatcherMock);
        $request = $this->createRegisterUserRequest();

        $useCase->execute($request);
    }

    public function test_register_user_fails_if_id_exists(): void
    {
        $existingUser = $this->createUser();

        $this->repositoryMock->method('findById')->willReturn($existingUser);

        $this->expectException(UserAlreadyExistsException::class);

        $useCase = new RegisterUserUseCase($this->repositoryMock, $this->dispatcherMock);
        $request = $this->createRegisterUserRequest($existingUser->getId()->value());

        $useCase->execute($request);
    }

    public function test_register_user_fails_if_email_exists(): void
    {
        $existingUser = $this->createUser();
        $this->repositoryMock->method('findByEmail')->willReturn($existingUser);

        $this->expectException(EmailAlreadyInUseException::class);

        $useCase = new RegisterUserUseCase($this->repositoryMock, $this->dispatcherMock);
        $request = $this->createRegisterUserRequest(null, $existingUser->getEmail()->value());

        $useCase->execute($request);
    }
}
