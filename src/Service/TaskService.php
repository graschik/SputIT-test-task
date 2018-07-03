<?php

declare(strict_types=1);

namespace App\Service;


use App\Entity\Task;
use Doctrine\ORM\EntityManagerInterface;

class TaskService
{
    private $entityManager;

    /**
     * TaskService constructor.
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @param Task $task
     */
    public function saveTask(Task $task)
    {
        $this->entityManager->persist($task);
        $this->entityManager->flush();
    }

    public function getTaskById(int $id): object
    {
        return $this
            ->entityManager
            ->getRepository(Task::class)
            ->find($id);
    }

    public function getTaskByStatus(string $status)
    {
        return $this
            ->entityManager
            ->getRepository(Task::class)
            ->findBy([
                'status' => $status
            ]);
    }

    public function getTasks()
    {
        return $this
            ->entityManager
            ->getRepository(Task::class)
            ->findAll();
    }
}