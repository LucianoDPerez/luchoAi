<?php

namespace App\Entity;

use App\Repository\PlanRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\OneToMany;
use Doctrine\ORM\Mapping\PrePersist;

#[ORM\Entity(repositoryClass: PlanRepository::class)]
class Plan
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(nullable: true)]
    private ?float $price = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $download_upload = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $description = '';

    #[ORM\Column(nullable: true)]
    private ?array $extra_data = null;

    #[ORM\Column(type: 'boolean')]
    private ?bool $isActive = true;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private \DateTimeInterface $createdAt;

    #[ORM\Column(type: 'datetime',nullable: true)]
    private \DateTimeInterface $updatedAt;



    #[ORM\OneToMany(mappedBy: 'plan', targetEntity: Client::class, orphanRemoval: true)]
    private Collection $clients;

    public function __construct()
    {
        $this->clients = new ArrayCollection();
    }

    /**
     * @PrePersist
     */
    public function setCreatedAtValue(): void
    {
        $this->createdAt = new \DateTimeImmutable();
    }
    public function setUpdatedAtValue(): void
    {
        $this->createdAt = new \DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(?float $price): static
    {
        $this->price = $price;

        return $this;
    }

    public function getDownloadUpload(): ?string
    {
        return $this->download_upload;
    }

    public function setDownloadUpload(?string $download_upload): static
    {
        $this->download_upload = $download_upload;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getExtraData(): ?array
    {
        return $this->extra_data;
    }

    public function setExtraData(?array $extra_data): static
    {
        $this->extra_data = $extra_data;

        return $this;
    }

    public function getIsActive(): ?bool
    {
        return $this->isActive;
    }

    public function setIsActive(bool $isActive): static
    {
        $this->isActive = $isActive;

        return $this;
    }

    /**
     * @return \DateTimeInterface
     */
    public function getCreatedAt(): \DateTimeInterface
    {
        return $this->createdAt;
    }

    /**
     * @return \DateTimeInterface
     */
    public function getUpdatedAt(): \DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function addClient(Client $client): self

    {

        if (!$this->clients->contains($client)) {

            $this->clients[] = $client;

            $client->setPlan($this);

        }


        return $this;

    }


    public function removeClient(Client $client): self

    {

        if ($this->clients->removeElement($client)) {

            // set the owning side to null (unless already changed)

            if ($client->getPlan() === $this) {

                $client->setPlan(null);

            }

        }


        return $this;

    }


    public function getClients(): Collection

    {

        return $this->clients;

    }
}
