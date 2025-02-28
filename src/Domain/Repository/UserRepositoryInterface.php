<?php

namespace Src\Domain\Repository;

use Src\Domain\Entity\User;
use Src\Domain\ValueObject\Email;
use Src\Domain\ValueObject\UserId;

interface UserRepositoryInterface
{
    public function save(User $user): void;

    public function findById(UserId $id): ?User;

    public function findByEmail(Email $email): ?User;

    public function delete(UserId $id): void;
}
