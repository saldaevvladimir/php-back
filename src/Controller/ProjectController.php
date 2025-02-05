<?php

declare(strict_types= 1);

namespace App\Controller;

use App\Entity\Project;
use App\Form\ProjectType;
use App\Repository\ProjectRepository;
use App\Repository\TaskRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Uid\Uuid;


#[Route('/projects')]
final class ProjectController extends BaseController {
    #[Route('/', name: 'projects', methods: ['GET'], format: 'json')]
    public function getProjects(ProjectRepository $projectRepository): JsonResponse {
        return $this->handleGetAll($projectRepository);
    }

    #[Route('/add', name: 'add_project', methods: ['POST'], format: 'json')]
    public function addProject(Request $request, EntityManagerInterface $em): JsonResponse {
        return $this->handleAdd($request, $em, ProjectType::class, new Project());
    }

    #[Route('/{id}', name: 'get_project', methods: ['GET'], format: 'json')]
    public function getProject(string $id, ProjectRepository $projectRepository): JsonResponse {
        return $this->handleGet($id, $projectRepository);
    }

    #[Route('/update/{id}', name: 'update_project', methods: ['PATCH'], format: 'json')]
    public function updateProject(string $id, Request $request, EntityManagerInterface $em, ProjectRepository $projectRepository): JsonResponse {
        return $this->handleUpdate($id, $request, $em, ProjectType::class, $projectRepository);
    }

    #[Route('/delete/{id}', name: 'delete_project', methods: ['DELETE'], format: 'json')]
    public function deleteProject(string $id, EntityManagerInterface $em, ProjectRepository $projectRepository): JsonResponse {
        return $this->handleDelete($id, $em, ProjectType::class, $projectRepository);
    }

    #[Route('/{projectId}/link_task/{taskId}', name: 'link_task_to_project', methods: ['POST'], format: 'json')]
    public function linkTaskToProject(string $projectId, string $taskId, EntityManagerInterface $em, ProjectRepository $projectRepository, TaskRepository $taskRepository): JsonResponse {
        $projectUuid = Uuid::fromString($projectId);
        $taskUuid = Uuid::fromString($taskId);

        $project = $projectRepository->find($projectUuid);
        $task = $taskRepository->find($taskUuid);

        if (!$project) {
            return $this->json(['data' => ['projectId' => 'Not found']], 404);
        }

        if (!$task) {
            return $this->json(['data' => ['taskId' => 'Not found']], 404);
        }

        $project->addTask($task);
        $em->persist($project);
        $em->flush();

        return $this->json(['data' => 'Task linked to project successfully']);
    }
}
