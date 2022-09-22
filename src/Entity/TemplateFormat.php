<?php

namespace App\Entity;

use App\Repository\TemplateFormatRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TemplateFormatRepository::class)]
class TemplateFormat
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\OneToMany(mappedBy: 'templateFormat', targetEntity: UserOfClient::class)]
    private Collection $userOfClients;

    public function __construct()
    {
        $this->userOfClients = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection<int, UserOfClient>
     */
    public function getUserOfClients(): Collection
    {
        return $this->userOfClients;
    }

    public function addUserOfClient(UserOfClient $userOfClient): self
    {
        if (!$this->userOfClients->contains($userOfClient)) {
            $this->userOfClients->add($userOfClient);
            $userOfClient->setTemplateFormat($this);
        }

        return $this;
    }

    public function removeUserOfClient(UserOfClient $userOfClient): self
    {
        if ($this->userOfClients->removeElement($userOfClient)) {
            // set the owning side to null (unless already changed)
            if ($userOfClient->getTemplateFormat() === $this) {
                $userOfClient->setTemplateFormat(null);
            }
        }

        return $this;
    }
}
