<?php

namespace App\Controller\Web;

use App\Service\StatusService;
use App\Service\TaskService;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class HomeController extends Controller
{
    /**
     * @Route("/", name="main_page")
     *
     * @param Request $request
     * @param TaskService $taskService
     * @return Response
     */
    public function mainAction(Request $request, TaskService $taskService)
    {
        return $this->render('show_task.html.twig', [
            'taskTODO' => $taskService->getTaskByStatus(StatusService::TODO),
            'taskDOING' => $taskService->getTaskByStatus(StatusService::DOING),
            'taskDONE' => $taskService->getTaskByStatus(StatusService::DONE)
        ]);
    }
}