<?php

declare(strict_types=1);

namespace App\Controller\Rest;


use App\Service\TaskService;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations as Rest;

class APIController extends FOSRestController
{
    /**
     * Retrieves a collection of Article resource
     * @Rest\Get("/tasks")
     * @param TaskService $taskService
     * @return View
     */
    public function getTasks(TaskService $taskService): View
    {
        return View::create($taskService->getTasks(), Response::HTTP_OK);
    }
}