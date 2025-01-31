<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\ProjectsGroupRepository;
use Doctrine\Common\Collections\ArrayCollection;
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

    public function getId(): ?Uuid {
        return $this->id;
    }

    public function setId(Uuid $id): void {
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

    #[ORM\OneToMany(targetEntity: Project::class, mappedBy: 'projectsGroup')]
    private ArrayCollection $projects;

    public function getProjects(): ArrayCollection {
        return $this->projects;
    }

    public function setProjects(ArrayCollection $projects): static {
        $this->projects = $projects;

        return $this;
    }

    public function addProject(Project $project): static {
        if (!$this->projects->contains($project)) {
            $this->projects->add($project);
            $project->setProjectsGroup($this);
        }

        return $this;
    }

    public function removeProject(Project $project): static {
        if ($this->projects->contains($project)) {
            $this->projects->removeElement($project);
            if ($project->getProjectsGroup() === $this) {
                $project->setProjectsGroup(null);
            }
        }

        return $this;
    }

    #[ORM\Column(name: 'created_at', type: 'datetime_immutable', nullable: false, options: ['default' => 'CURRENT_TIMESTAMP'])]
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

    #[ORM\Column(name: 'updated_at', type: 'datetime_immutable', nullable: false, options: ['default' => 'CURRENT_TIMESTAMP'])]
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