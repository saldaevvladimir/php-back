<?php

namespace App\Factory;

use App\DTO\ProjectsGroupDTO;
use App\Entity\ProjectsGroup;

class ProjectsGroupFactory {
    private ProjectFactory $projectFactory;

    public function __construct(ProjectFactory $projectFactory) {
        $this->projectFactory = $projectFactory;
    }

    public function createFromEntity(ProjectsGroup $projectsGroup): ProjectsGroupDTO {
        $projectData = $this->projectFactory->createFromEntities($projectsGroup->getProjects()->toArray(), false);

        return new ProjectsGroupDTO(
            $projectsGroup->getId(),
            $projectsGroup->getName(),
            $projectsGroup->getCreatedAt(),
            $projectsGroup->getUpdatedAt(),
            $projectData,
        );
    }

    public function createFromEntities(array $projectsGroups): array {
        return array_map(fn(ProjectsGroup $projectsGroup) => $this->createFromEntity($projectsGroup), $projectsGroups);
    }
}