<?php

declare(strict_types= 1);

namespace App\Controller;

use App\Entity\Task;
use App\Form\TaskType;
use App\Repository\TaskRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/web/tasks')]
final class TaskController extends AbstractController {
    #[Route('/', name: 'tasks_web', methods: ['GET'])]
    public function getTasks(TaskRepository $taskRepository): Response {
        return $this->render('task/index.html.twig', [
            'tasks' => $taskRepository->findAll()
        ]);
    }

    #[Route('/{id}', name: 'get_task_web', methods: ['GET'])]
    public function getTask(Task $task): Response {
        return $this->render('task/show.html.twig', [
            'task' => $task
        ]);
    }

    #[Route('/edit/{id}', name: 'edit_task_web', methods: ['GET', 'POST'])]
    public function editTask(Request $request, Task $task, EntityManagerInterface $em): Response {
        $form = $this->createForm(TaskType::class, $task);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();

            return $this->redirectToRoute('tasks_web', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('task/edit.html.twig', [
            'task' => $task,
            'form' => $form,
        ]);
    }

    #[Route('/delete/{id}', name: 'delete_task_web', methods: ['POST'])]
    public function deleteTask(Request $request, Task $task, EntityManagerInterface $em): Response {
        if ($this->isCsrfTokenValid('delete' . $task->getId(), $request->request->get('_token'))) {
            $em->remove($task);
            $em->flush();
        }

        return $this->redirectToRoute('tasks_web', [], Response::HTTP_SEE_OTHER);
    }
}
