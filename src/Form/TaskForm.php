<?php

declare(strict_types=1);

namespace App\Form;


use App\Entity\Task;
use App\Service\StatusService;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TaskForm extends AbstractType
{
    private $statusService;

    /**
     * TaskForm constructor.
     * @param StatusService $statusService
     */
    public function __construct(StatusService $statusService)
    {
        $this->statusService = $statusService;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('status', ChoiceType::class, [
                'label' => 'Status',
                'choices' => [
                    $this->statusService::TODO => $this->statusService::TODO,
                    $this->statusService::DOING => $this->statusService::DOING,
                    $this->statusService::DONE => $this->statusService::DONE
                ]
            ])
            ->add('name', TextType::class, [
                'label' => 'Name:',
                'attr' => [
                    'placeholder' => 'Enter name'
                ]
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Description:',
                'attr' => [
                    'placeholder' => 'Enter description'
                ]
            ])
            ->add('confirm', SubmitType::class, [
                'label' => 'Save',
            ]);
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Task::class,
        ]);
    }
}