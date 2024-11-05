<?php

declare(strict_types= 1);

namespace App\Controller;

use App\Entity\ProjectsGroup;
use App\Form\ProjectsGroupType;
use App\Repository\ProjectsGroupRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;


#[Route('/project_groups')]
final class ProjectsGroupController extends BaseController {
    #[Route('/', name: 'project_groups', methods: ['GET'], format: 'json')]
    public function getProjectsGroups(ProjectsGroupRepository $projectsGroupRepository): JsonResponse {
        return $this->handleGetAll($projectsGroupRepository);
    }

    #[Route('/add', name: 'add_projects_group', methods: ['POST'], format: 'json')]
    public function addProjectsGroup(Request $request, EntityManagerInterface $em): JsonResponse {
        return $this->handleAdd($request, $em, ProjectsGroupType::class, new ProjectsGroup());
    }

    #[Route('/{id}', name: 'get_projects_group', methods: ['GET'], format: 'json')]
    public function getProjectsGroup(string $id, ProjectsGroupRepository $projectsGroupRepository): JsonResponse {
        return $this->handleGet($id, $projectsGroupRepository);
    }

    #[Route('/update/{id}', name: 'update_projects_group', methods: ['PATCH'], format: 'json')]
    public function updateProjectsGroup(string $id, Request $request, EntityManagerInterface $em, ProjectsGroupRepository $projectsGroupRepository): JsonResponse {
        return $this->handleUpdate($id, $request, $em, ProjectsGroupType::class, $projectsGroupRepository);
    }

    #[Route('/delete/{id}', name: 'delete_projects_group', methods: ['DELETE'], format: 'json')]
    public function deleteProjectsGroup(string $id, EntityManagerInterface $em, ProjectsGroupRepository $projectsGroupRepository): JsonResponse {
        return $this->handleDelete($id, $em, ProjectsGroupType::class, $projectsGroupRepository);
    }
}
