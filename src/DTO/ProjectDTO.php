<?php

namespace App\DTO;

class ProjectDTO {
    public readonly ?string $id;
    public readonly ?string $name;

    public readonly ?\DateTimeImmutable $createdAt;
    public readonly ?\DateTimeImmutable $updatedAt;
    public readonly ?array $tasks;
    public readonly ?string $projectsGroupId;
    public readonly ?string $projectsGroupName;

    public function __construct(
        ?string $id,
        ?string $name,
        ?\DateTimeImmutable $createdAt,
        ?\DateTimeImmutable $updatedAt,
        ?array $tasks = null,
        ?string $projectsGroupId = null,
        ?string $projectsGroupName = null
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
        if ($tasks !== null && $projectsGroupId !== null && $projectsGroupName !== null) {
            $this->tasks = $tasks;
            $this->projectsGroupId = $projectsGroupId;
            $this->projectsGroupName = $projectsGroupName;
        }
    }
}