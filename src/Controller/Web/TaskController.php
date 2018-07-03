<?php

namespace App\Controller\Web;


use App\Form\CommentForm;
use App\Form\TaskForm;
use App\Service\FormHandler;
use App\Service\StatusService;
use App\Service\TaskService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Translation\Exception\NotFoundResourceException;

class TaskController extends Controller
{
    /**
     * @Route("/create_task", name="create_task")
     * @param Request $request
     * @param FormHandler $formHandler
     * @param TaskService $taskService
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function createAction(
        Request $request,
        FormHandler $formHandler,
        TaskService $taskService
    )
    {
        $form = $this->createForm(TaskForm::class);

        if ($formHandler->handle($form, $request)) {
            $task = $form->getData();
            $taskService->saveTask($task);
            return $this->render('show_task.html.twig', [
                'taskTODO' => $taskService->getTaskByStatus(StatusService::TODO),
                'taskDOING' => $taskService->getTaskByStatus(StatusService::DOING),
                'taskDONE' => $taskService->getTaskByStatus(StatusService::DONE)
            ]);
        }

        return $this->render('task.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/update/task/{id}", name="task_update")
     * @param Request $request
     * @param FormHandler $formHandler
     * @param TaskService $taskService
     * @param int $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function updateAction(
        Request $request,
        FormHandler $formHandler,
        TaskService $taskService,
        int $id
    )
    {
        $task = $taskService->getTaskById($id);
        if (!$task) {
            throw new NotFoundResourceException('This task does not exist!');
        }

        $form = $this->createForm(TaskForm::class, $task);
        $commentForm = $this->createForm(CommentForm::class);

        if ($formHandler->handle($form, $request)) {
            $task = $form->getData();
            $taskService->saveTask($task);
            return $this->redirectToRoute('main_page');
        }

        return $this->render('task_update.html.twig', [
            'form' => $form->createView(),
            'commentForm' => $commentForm->createView(),
            'comments' => $task->getComments(),
            'id' => $id,
        ]);
    }
}