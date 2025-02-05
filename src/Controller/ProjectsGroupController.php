<?php

declare(strict_types= 1);

namespace App\Controller;

use App\Entity\ProjectsGroup;
use App\Form\ProjectsGroupType;
use App\Repository\ProjectsGroupRepository;
use App\Repository\ProjectRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Uid\Uuid;


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

    #[Route('/{projectsGroupId}/link_project/{projectId}', name: 'link_project_to_projects_group', methods: ['POST'], format: 'json')]
    public function linkProjectToProjectsGroup(string $projectsGroupId, string $projectId, EntityManagerInterface $em, ProjectsGroupRepository $projectsGroupRepository, ProjectRepository $projectRepository): JsonResponse {
        $projectsGroupUuid = Uuid::fromString($projectsGroupId);
        $projectUuid = Uuid::fromString($projectId);

        $projectsGroup = $projectsGroupRepository->find($projectsGroupUuid);
        $project = $projectRepository->find($projectUuid);

        if (!$projectsGroup) {
            return $this->json(['data' => ['projectsGroupId' => 'Not found']], 404);
        }

        if (!$project) {
            return $this->json(['data' => ['projectId' => 'Not found']], 404);
        }

        $projectsGroup->addProject($project);
        $em->persist($projectsGroup);
        $em->flush();

        return $this->json(['data' => 'Project linked to projects group successfully']);
    }
}
