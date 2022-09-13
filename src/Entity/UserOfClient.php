<?php

namespace App\Entity;

use App\Repository\UserOfClientRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserOfClientRepository::class)]
class UserOfClient
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $email = null;

    #[ORM\ManyToOne(inversedBy: 'clients')]
    private ?User $userPropriety = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getUserPropriety(): ?User
    {
        return $this->userPropriety;
    }

    public function setUserPropriety(?User $userPropriety): self
    {
        $this->userPropriety = $userPropriety;

        return $this;
    }
}
