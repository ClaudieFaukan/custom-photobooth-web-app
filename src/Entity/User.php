<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\UserRepository;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use UserConstante;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
#[UniqueEntity(fields: ['email'], message: 'There is already an account with this email')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $firstName = null;

    #[ORM\Column(length: 255)]
    private ?string $lastName = null;

    #[ORM\Column(length: 255)]
    private ?string $email = null;

    #[ORM\Column(length: 255)]
    private ?string $password = null;

    #[ORM\Column]
    private array $roles = [UserConstante::ROLE_USER];

    #[ORM\Column(type: 'boolean')]
    private $isVerified = false;

    #[ORM\OneToMany(mappedBy: 'userPropriety', targetEntity: UserOfClient::class)]
    private Collection $clients;

    #[ORM\OneToMany(mappedBy: 'userPropriety', targetEntity: OptionCustomClient::class)]
    private Collection $options;

    #[ORM\OneToMany(mappedBy: 'userPropriety', targetEntity: CustomProfilUser::class)]
    private Collection $customProfil;

    public function __construct()
    {
        $this->clients = new ArrayCollection();
        $this->options = new ArrayCollection();
        $this->customProfil = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }


    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }
    /**
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    public function getRoles(): array
    {
        return $this->roles;
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    public function isVerified(): bool
    {
        return $this->isVerified;
    }

    public function setIsVerified(bool $isVerified): self
    {
        $this->isVerified = $isVerified;

        return $this;
    }

    public function isIsVerified(): ?bool
    {
        return $this->isVerified;
    }

    /**
     * @return Collection<int, UserOfClient>
     */
    public function getClients(): Collection
    {
        return $this->clients;
    }

    public function addClient(UserOfClient $client): self
    {
        if (!$this->clients->contains($client)) {
            $this->clients->add($client);
            $client->setUserPropriety($this);
        }

        return $this;
    }

    public function removeClient(UserOfClient $client): self
    {
        if ($this->clients->removeElement($client)) {
            // set the owning side to null (unless already changed)
            if ($client->getUserPropriety() === $this) {
                $client->setUserPropriety(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, OptionCustomClient>
     */
    public function getOptions(): Collection
    {
        return $this->options;
    }

    public function addOption(OptionCustomClient $option): self
    {
        if (!$this->options->contains($option)) {
            $this->options->add($option);
            $option->setUserPropriety($this);
        }

        return $this;
    }

    public function removeOption(OptionCustomClient $option): self
    {
        if ($this->options->removeElement($option)) {
            // set the owning side to null (unless already changed)
            if ($option->getUserPropriety() === $this) {
                $option->setUserPropriety(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, CustomProfilUser>
     */
    public function getCustomProfil(): Collection
    {
        return $this->customProfil;
    }

    public function addCustomProfil(CustomProfilUser $customProfil): self
    {
        if (!$this->customProfil->contains($customProfil)) {
            $this->customProfil->add($customProfil);
            $customProfil->setUserPropriety($this);
        }

        return $this;
    }

    public function removeCustomProfil(CustomProfilUser $customProfil): self
    {
        if ($this->customProfil->removeElement($customProfil)) {
            // set the owning side to null (unless already changed)
            if ($customProfil->getUserPropriety() === $this) {
                $customProfil->setUserPropriety(null);
            }
        }

        return $this;
    }
}
