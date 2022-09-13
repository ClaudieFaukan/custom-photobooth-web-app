<?php

namespace App\Entity;

use App\Repository\OptionCustomClientRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OptionCustomClientRepository::class)]
class OptionCustomClient
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private array $templateFormat = [];

    #[ORM\ManyToOne(inversedBy: 'options')]
    private ?User $userPropriety = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTemplateFormat(): array
    {
        return $this->templateFormat;
    }

    public function setTemplateFormat(array $templateFormat): self
    {
        $this->templateFormat = $templateFormat;

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
