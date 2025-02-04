<?php

declare(strict_types= 1);

namespace App\Controller;

use App\Entity\ProjectsGroup;
use App\Form\ProjectsGroupType;
use App\Repository\ProjectsGroupRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;


#[Route('/web/projects_groups')]
final class ProjectsGroupController extends AbstractController {
    #[Route('/', name: 'projects_groups_web', methods: ['GET'])]
    public function getProjectsGroups(ProjectsGroupRepository $projectsGroupRepository): Response {
        return $this->render('projects_group/index.html.twig', [
           'projects_groups' => $projectsGroupRepository->findAll(),
        ]);
    }

    #[Route('/{id}', name: 'get_projects_group_web', methods: ['GET'])]
    public function getProjectsGroup(Request $request, ProjectsGroup $projectsGroup, EntityManagerInterface $em): Response {
        return $this->render('projects_group/show.html.twig', [
            'projects_group' => $projectsGroup
        ]);
    }

    #[Route('/edit/{id}', name: 'edit_projects_group_web', methods: ['GET', 'POST'])]
    public function editProjectsGroup(Request $request, ProjectsGroup $projectsGroup, EntityManagerInterface $em): Response {
        $form = $this->createForm(ProjectsGroupType::class, $projectsGroup);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();

            return $this->redirectToRoute('project_groups_web', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('projects_group/edit.html.twig', [
            'projects_group' => $projectsGroup,
            'form' => $form,
        ]);
    }

    #[Route('/delete/{id}', name: 'delete_projects_group_web', methods: ['DELETE'])]
    public function deleteProjectsGroup(Request $request, ProjectsGroup $projectsGroup, EntityManagerInterface $em): Response {
        if ($this->isCsrfTokenValid('delete' . $projectsGroup->getId(), $request->request->get('_token'))) {
            $em->remove($projectsGroup);
            $em->flush();
        }

        return $this->redirectToRoute('projects_groups_web', [], Response::HTTP_SEE_OTHER);
    }
}
