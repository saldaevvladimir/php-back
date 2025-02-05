<?php

declare(strict_types= 1);

namespace App\Controller;

use App\Entity\Project;
use App\Form\ProjectType;
use App\Repository\ProjectRepository;
use App\Repository\TaskRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Uid\Uuid;


#[Route('/web/projects')]
final class ProjectController extends AbstractController {
    #[Route('/', name: 'projects_web', methods: ['GET'])]
    public function getProjects(ProjectRepository $projectRepository): Response {
        return $this->render('project/index.html.twig', [
            'projects' => $projectRepository->findAll(),
        ]);
    }

    #[Route('/{id}', name: 'get_project_web', methods: ['GET'])]
    public function getProject(Project $project): Response {
        return $this->render('project/show.html.twig', [
            'project' => $project
        ]);
    }

    #[Route('/edit/{id}', name: 'edit_project_web', methods: ['GET', 'POST'])]
    public function editProject(Request $request, Project $project, EntityManagerInterface $em): Response {
        $form = $this->createForm(ProjectType::class, $project);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();

            return $this->redirectToRoute('projects_web', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('project/edit.html.twig', [
            'project' => $project,
            'form' => $form,
        ]);
    }

    #[Route('/delete/{id}', name: 'delete_project_web', methods: ['POST'])]
    public function deleteProject(Request $request, Project $project, EntityManagerInterface $em): Response {
        if ($this->isCsrfTokenValid('delete' . $project->getId(), $request->request->get('_token'))) {
            $em->remove($project);
            $em->flush();
        }

        return $this->redirectToRoute('projects_web', [], Response::HTTP_SEE_OTHER);
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
