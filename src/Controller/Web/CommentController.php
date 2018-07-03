<?php

declare(strict_types=1);

namespace App\Controller\Web;


use App\Form\CommentForm;
use App\Service\CommentService;
use App\Service\FormHandler;
use App\Service\TaskService;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class CommentController extends Controller
{

    /**
     * @Route("/comment/add/{taskId}", name="add_comment")
     * @param Request $request
     * @param TaskService $taskService
     * @param FormHandler $formHandler
     * @param CommentService $commentService
     * @param int $taskId
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function addComment(Request $request, TaskService $taskService, FormHandler $formHandler, CommentService $commentService, int $taskId)
    {
        $task = $taskService->getTaskById($taskId);
        if (!$task) {
            return $this->redirectToRoute('task_update', [
                'id' => $taskId,
            ]);
        }

        $form = $this->createForm(CommentForm::class);

        if ($formHandler->handle($form, $request)) {
            $commentService->addCommentToTask($form->getData(), $task);
        }

        return $this->redirectToRoute('task_update', [
            'id' => $taskId,
        ]);
    }
}