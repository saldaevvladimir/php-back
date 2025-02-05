<?php

namespace App\DTO;

class ProjectsGroupDTO {
    public readonly ?string $id;
    public readonly ?string $name;
    public readonly ?\DateTimeImmutable $createdAt;
    public readonly ?\DateTimeImmutable $updatedAt;
    public readonly array $projects;

    public function __construct(
        ?string $id,
        ?string $name,
        ?\DateTimeImmutable $createdAt,
        ?\DateTimeImmutable $updatedAt,
        array $projects
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
        $this->projects = $projects;
    }
}