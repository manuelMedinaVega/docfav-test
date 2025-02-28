<?php

namespace Src\Domain\Entity;

use Doctrine\ORM\Mapping as ORM;
use Src\Domain\ValueObject\Email;
use Src\Domain\ValueObject\Name;
use Src\Domain\ValueObject\Password;
use Src\Domain\ValueObject\UserId;

#[ORM\Entity]
#[ORM\Table(name: 'users')]
class User
{
    #[ORM\Id]
    #[ORM\Column(type: 'string', length: 36, unique: true)]
    private string $id;

    #[ORM\Column(type: 'string', length: 100)]
    private string $name;

    #[ORM\Column(type: 'string', length: 255, unique: true)]
    private string $email;

    #[ORM\Column(type: 'string', length: 255)]
    private string $password;

    #[ORM\Column(type: 'datetime', options: ['default' => 'CURRENT_TIMESTAMP'])]
    private \DateTime $createdAt;

    public function __construct(UserId $id, Name $name, Email $email, Password $password)
    {
        $this->id = $id->value();
        $this->name = $name->value();
        $this->email = $email->value();
        $this->password = $password->value();
        $this->createdAt = new \DateTime;
    }

    public function getId(): UserId
    {
        return new UserId($this->id);
    }

    public function getName(): Name
    {
        return new Name($this->name);
    }

    public function getEmail(): Email
    {
        return new Email($this->email);
    }

    public function getPassword(): Password
    {
        return new Password($this->password);
    }

    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }
}
