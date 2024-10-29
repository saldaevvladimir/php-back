<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\ProjectsGroupRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Types\UuidType;
use Symfony\Component\Uid\Uuid;


#[ORM\Entity(repositoryClass: ProjectsGroupRepository::class)]
#[ORM\Table(name: 'projects_groups')]
#[ORM\HasLifecycleCallbacks()]
class ProjectsGroup {
    public function __construct() {
        $this->id = Uuid::v4();
        $this->createdAt = new \DateTimeImmutable();
        $this->updatedAt = new \DateTimeImmutable();
    }

    #[ORM\Id]
    #[ORM\Column(type: UuidType::NAME, unique: true)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: 'doctrine.uuid_generator')]
    private ?Uuid $id;

    public function getId(): ?UuidType {
        return $this->id;
    }

    public function setId(UuidType $id): void {
        $this->id = $id;
    }

    #[ORM\Column(name: 'name', length: 128, nullable: false)]
    private string $name;

    public function getName(): string {
        return $this->name;
    }

    public function setName(string $name): void {
        $this->name = $name;
    }

    #[ORM\Column(name: 'created_at', type: 'datetime_immutable', options: ['default' => 'CURRENT_TIMESTAMP'], nullable: false)]
    private \DatetimeImmutable $createdAt;

    public function getCreatedAt(): \DateTimeImmutable {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): self {
        $this->createdAt = $createdAt;
        return $this;
    }

    #[ORM\PrePersist]
    public function setCreatedAtValue(): void {
        $this->createdAt = new \DateTimeImmutable();
    }

    #[ORM\Column(name: 'updated_at', type: 'datetime_immutable', options: ['default' => 'CURRENT_TIMESTAMP'], nullable: false)]
    private \DateTimeImmutable $updatedAt;

    public function getUpdatedAt(): \DateTimeImmutable {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeImmutable $updatedAt): self {
        $this->updatedAt = $updatedAt;
        return $this;
    }

    #[ORM\PrePersist]
    #[ORM\PreUpdate]
    public function updateUpdatedAt(): void {
        $this->updatedAt = new \DateTimeImmutable();
    }
}

?>