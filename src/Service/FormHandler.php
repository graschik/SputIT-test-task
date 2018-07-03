<?php

declare(strict_types=1);

namespace App\Service;


use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;

class FormHandler
{
    /**
     * @param FormInterface $form
     * @param Request $request
     * @return bool
     */
    public function handle(FormInterface $form, Request $request): bool
    {
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            return true;
        }

        return false;
    }
}