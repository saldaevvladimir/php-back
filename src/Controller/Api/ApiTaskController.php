<?php

declare(strict_types= 1);

namespace App\Controller\Api;

use App\Entity\Task;
use App\Form\TaskType;
use App\Repository\TaskRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api/tasks')]
final class ApiTaskController extends BaseApiController {
    #[Route('/', name: 'tasks_api', methods: ['GET'], format: 'json')]
    public function getTasks(TaskRepository $taskRepository): JsonResponse {
        return $this->handleGetAll($taskRepository);
    }

    #[Route('/add', name: 'add_task_api', methods: ['POST'], format: 'json')]
    public function addTask(Request $request, EntityManagerInterface $em): JsonResponse {
        return $this->handleAdd($request, $em, TaskType::class, new Task());
    }

    #[Route('/{id}', name: 'get_task_api', methods: ['GET'], format: 'json')]
    public function getTask(string $id, TaskRepository $taskRepository): JsonResponse {
        return $this->handleGet($id, $taskRepository);
    }

    #[Route('/update/{id}', name: 'update_task_api', methods: ['PATCH'], format: 'json')]
    public function updateTask(string $id, Request $request, EntityManagerInterface $em, TaskRepository $taskRepository): JsonResponse {
        return $this->handleUpdate($id, $request, $em, TaskType::class, $taskRepository);
    }

    #[Route('/delete/{id}', name: 'delete_api', methods: ['DELETE'], format: 'json')]
    public function deleteTask(string $id, EntityManagerInterface $em, TaskRepository $taskRepository): JsonResponse {
        return $this->handleDelete($id, $em, TaskType::class, $taskRepository);
    }
}
