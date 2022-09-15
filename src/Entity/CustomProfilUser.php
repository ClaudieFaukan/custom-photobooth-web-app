<?php

namespace App\Entity;

use App\Repository\CustomProfilUserRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CustomProfilUserRepository::class)]
class CustomProfilUser
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $logo = null;

    #[ORM\Column(length: 255)]
    private ?string $color1 = null;

    #[ORM\Column(length: 255)]
    private ?string $color2 = null;

    #[ORM\Column(length: 255)]
    private ?string $color3 = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\ManyToOne(inversedBy: 'customProfil')]
    private ?User $userPropriety = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $pictureProfil = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $pictureProfilBackground = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLogo(): ?string
    {
        return $this->logo;
    }

    public function setLogo(?string $logo): self
    {
        $this->logo = $logo;

        return $this;
    }

    public function getColor1(): ?string
    {
        return $this->color1;
    }

    public function setColor1(string $color1): self
    {
        $this->color1 = $color1;

        return $this;
    }

    public function getColor2(): ?string
    {
        return $this->color2;
    }

    public function setColor2(string $color2): self
    {
        $this->color2 = $color2;

        return $this;
    }

    public function getColor3(): ?string
    {
        return $this->color3;
    }

    public function setColor3(string $color3): self
    {
        $this->color3 = $color3;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

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

    public function getPictureProfil(): ?string
    {
        return $this->pictureProfil;
    }

    public function setPictureProfil(?string $pictureProfil): self
    {
        $this->pictureProfil = $pictureProfil;

        return $this;
    }

    public function getPictureProfilBackground(): ?string
    {
        return $this->pictureProfilBackground;
    }

    public function setPictureProfilBackground(?string $pictureProfilBackground): self
    {
        $this->pictureProfilBackground = $pictureProfilBackground;

        return $this;
    }
}
