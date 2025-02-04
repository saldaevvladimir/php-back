<?php

declare(strict_types= 1);

namespace App\Controller\Api;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Uid\Uuid;


abstract class BaseApiController extends AbstractController {
    protected function handleAdd(Request $request, EntityManagerInterface $em, $formType, $entity): JsonResponse {
        $data = json_decode($request->getContent(), true);
        $form = $this->createForm($formType, $entity);
        $form->submit($data);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($entity);
            $em->flush();
            return $this->json(['data' => $entity]);
        } else {
            $errors = $formType->customGetErrors($form);
            return $this->json(['data' => $errors], 400);
        }
    }

    protected function handleUpdate(string $id, Request $request, EntityManagerInterface $em, $formType, $repository): JsonResponse {
        $uuid = Uuid::fromString($id);
        $entity = $repository->find($uuid);

        if (!$entity) {
            return $this->json(['data'=> ['id'=> 'Not found']], 404);
        }

        $entity->updateUpdatedAt();

        return $this->handleAdd($request, $em, $formType, $entity);
    }

    protected function handleDelete(string $id, EntityManagerInterface $em, $repository): JsonResponse {
        $uuid = Uuid::fromString($id);
        $entity = $repository->find($uuid);

        if (!$entity) {
            return $this->json(['data'=> ['id'=> 'Not found']], 404);
        }

        $em->remove($entity);
        $em->flush();
        
        return new JsonResponse(null, JsonResponse::HTTP_NO_CONTENT);
    }
    
    protected function handleGet(string $id, $repository): JsonResponse {
        $uuid = Uuid::fromString($id);
        $entity = $repository->find($uuid);

        if (!$entity) {
            return $this->json(['data'=> ['id'=> 'Not found']], 404);
        }
        
        return $this->json(['data'=> $entity]);
    }

    protected function handleGetAll($repository): JsonResponse {
        $entities = $repository->findAll();

        if (!$entities) {
            return $this->json(['data'=> 'No entities found']);
        }

        return $this->json(['data'=> $entities]);
    }
}