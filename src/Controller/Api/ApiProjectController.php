<?php

declare(strict_types= 1);

namespace App\Controller\Api;

use App\Entity\Project;
use App\Factory\ProjectFactory;
use App\Form\ProjectType;
use App\Repository\ProjectRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api/projects')]
final class ApiProjectController extends BaseApiController {
    #[Route('/', name: 'projects_api', methods: ['GET'], format: 'json')]
    public function getProjects(ProjectRepository $projectRepository, ProjectFactory $projectFactory): JsonResponse {
        return $this->handleGetAll($projectRepository, $projectFactory);
    }

    #[Route('/add', name: 'add_project_api', methods: ['POST'], format: 'json')]
    public function addProject(Request $request, EntityManagerInterface $em): JsonResponse {
        return $this->handleAdd($request, $em, ProjectType::class, new Project());
    }

    #[Route('/{id}', name: 'get_project_api', methods: ['GET'], format: 'json')]
    public function getProject(string $id, ProjectRepository $projectRepository, ProjectFactory $projectFactory): JsonResponse {
        return $this->handleGet($id, $projectRepository, $projectFactory);
    }

    #[Route('/update/{id}', name: 'update_project_api', methods: ['PATCH'], format: 'json')]
    public function updateProject(string $id, Request $request, EntityManagerInterface $em, ProjectRepository $projectRepository): JsonResponse {
        return $this->handleUpdate($id, $request, $em, ProjectType::class, $projectRepository);
    }

    #[Route('/delete/{id}', name: 'delete_project_api', methods: ['DELETE'], format: 'json')]
    public function deleteProject(string $id, EntityManagerInterface $em, ProjectRepository $projectRepository): JsonResponse {
        return $this->handleDelete($id, $em, ProjectType::class, $projectRepository);
    }
}
