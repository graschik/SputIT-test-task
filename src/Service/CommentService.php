<?php

declare(strict_types=1);

namespace App\Service;


use App\Entity\Comment;
use App\Entity\Task;
use Doctrine\ORM\EntityManagerInterface;

class CommentService
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function addCommentToTask(Comment $comment, object $task)
    {
        $comment->setTask($task);
        $this->commit($comment);
    }

    public function commit(Comment $comment)
    {
        $this->entityManager->persist($comment);
        $this->entityManager->flush();
    }
}