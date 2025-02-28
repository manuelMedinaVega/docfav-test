<?php

use Faker\Factory;
use PHPUnit\Framework\TestCase;
use Src\Domain\Entity\User;
use Src\Domain\ValueObject\Email;
use Src\Domain\ValueObject\Name;
use Src\Domain\ValueObject\Password;
use Src\Domain\ValueObject\UserId;
use Src\Infrastructure\Persistence\Doctrine\DoctrineUserRepository;

final class DoctrineUserRepositoryTest extends TestCase
{
    private DoctrineUserRepository $repository;

    private $faker;

    protected function setUp(): void
    {
        require_once __DIR__.'/../../../config/bootstrap.php';

        $this->repository = new DoctrineUserRepository($entityManager);
        $this->faker = Factory::create('es_ES');
    }

    public function test_save_and_find_user(): void
    {
        $user = new User(
            new UserId($this->faker->uuid()),
            new Name($this->faker->firstName().' '.$this->faker->lastName()),
            new Email($this->faker->unique()->safeEmail()),
            new Password($this->faker->password(8, 16).'A@1')
        );

        $this->repository->save($user);
        $foundUser = $this->repository->findById($user->getId());

        $this->assertInstanceOf(User::class, $foundUser);
        $this->assertSame($user->getId()->value(), $foundUser->getId()->value());
        $this->assertSame($user->getName()->value(), $foundUser->getName()->value());
        $this->assertSame($user->getEmail()->value(), $foundUser->getEmail()->value());
    }
}
