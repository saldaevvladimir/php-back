<?php

namespace App\DTO;

class TaskDTO {
    public readonly ?string $id;
    public readonly ?string $name;
    public readonly ?string $description;
    public readonly ?\DateTimeImmutable $createdAt;
    public readonly ?\DateTimeImmutable $updatedAt;
    public readonly ?string $projectId;
    public readonly ?string $projectName;

    public function __construct(
        ?string $id,
        ?string $name,
        ?string $description,
        ?\DateTimeInterface $createdAt,
        ?\DateTimeInterface $updatedAt,
        ?string $projectId = null,
        ?string $projectName = null
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
        if ($projectId !== null and $projectName !== null) {
            $this->projectId = $projectId;
            $this->projectName = $projectName;
        }
    }
}