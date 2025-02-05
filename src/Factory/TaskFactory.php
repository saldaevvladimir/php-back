<?php

namespace App\Factory;

use App\DTO\TaskDTO;
use App\Entity\Task;

class TaskFactory {
    public function createFromEntity(Task $task, bool $includeRelatedData = true): TaskDTO {
        if ($includeRelatedData) {
            $project = $task->getProject();
            $projectName = $project?->getName();
            $projectId = $project?->getId();

            return new TaskDTO(
                $task->getId(),
                $task->getName(),
                $task->getDescription(),
                $task->getCreatedAt(),
                $task->getUpdatedAt(),
                $projectId,
                $projectName
            );
        }

        return new TaskDTO(
            $task->getId(),
            $task->getName(),
            $task->getDescription(),
            $task->getCreatedAt(),
            $task->getUpdatedAt()
        );
    }

    public function createFromEntities(array $tasks, bool $includeRelatedData = true): array {
        return array_map(fn(Task $task) => $this->createFromEntity($task, $includeRelatedData), $tasks);
    }
}