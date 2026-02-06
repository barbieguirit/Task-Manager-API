<?php

namespace App\Controller\Api;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Task;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\Response;

final class TaskController extends AbstractController
{
    #[Route('/api/tasks', methods: ['GET'])]
    public function index(EntityManagerInterface $em, SerializerInterface $serializer): JsonResponse
    {
        $tasks = $em->getRepository(Task::class)->findAll();
        $json_content = $serializer->serialize($tasks, 'json', ['groups' => 'task:read']);
        return new JsonResponse($json_content, 200, [], true);  
    }

    #[Route('/api/tasks', methods: ['POST'])]
    public function create(Request $request, EntityManagerInterface $em): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $task = new Task();
        $task->setTitle($data['title'] ?? '');
        $task->setDescription($data['description'] ?? null);

        $em->persist($task);
        $em->flush();

        return $this->json($task, 201, [], ['groups' => 'task:read']);
    }

    #[Route('/api/tasks/{id}', methods: ['GET'])]
    public function show(int $id, EntityManagerInterface $em): JsonResponse
    {
        $task = $em->getRepository(Task::class)->find($id);
        
        if (!$task) {
            return $this->json(['error' => 'Task not found'], 404);
        }

        return $this->json($task, 200, [], ['groups' => 'task:read']);
    }

    #[Route('/api/tasks/{id}', methods: ['PUT'])]
    public function update(int $id, Request $request, EntityManagerInterface $em): JsonResponse
    {
        $task = $em->getRepository(Task::class)->find($id);
        
        if (!$task) {
            return $this->json(['error' => 'Task not found'], 404);
        }

        $data = json_decode($request->getContent(), true);

        if (isset($data['title'])) {
            $task->setTitle($data['title']);
        }
        if (isset($data['description'])) {
            $task->setDescription($data['description']);
        }
        if (isset($data['isCompleted'])) {
            $task->setIsCompleted($data['isCompleted']);
        }

        $em->flush();

        return $this->json($task, 200, [], ['groups' => 'task:read']);
    }

    #[Route('/api/tasks/{id}', methods: ['PATCH'])]
    public function patch(int $id, Request $request, EntityManagerInterface $em): JsonResponse
    {
        $task = $em->getRepository(Task::class)->find($id);
        
        if (!$task) {
            return $this->json(['error' => 'Task not found'], 404);
        }

        $data = json_decode($request->getContent(), true);

        if (isset($data['title'])) {
            $task->setTitle($data['title']);
        }
        if (isset($data['description'])) {
            $task->setDescription($data['description']);
        }
        if (isset($data['isCompleted'])) {
            $task->setIsCompleted($data['isCompleted']);
        }

        $em->flush();

        return $this->json($task, 200, [], ['groups' => 'task:read']);
    }

    #[Route('/api/tasks/{id}', methods: ['DELETE'])]
    public function delete(int $id, EntityManagerInterface $em): JsonResponse
    {
        $task = $em->getRepository(Task::class)->find($id);
        
        if (!$task) {
            return $this->json(['error' => 'Task not found'], 404);
        }

        $em->remove($task);
        $em->flush();

        return $this->json(null, 204);
    }
}
