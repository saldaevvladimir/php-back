<?php

declare(strict_types= 1);

namespace App\Form;

use App\Entity\Task;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;


class TaskType extends BaseType {
    public function buildForm(FormBuilderInterface $builder, array $options): void {
        $fieldsWithConstraints = [
            'name' => [
                new Assert\NotNull(),
                new Assert\Length(['min' => 3, 'max' => 128])
            ],
            'description' => [
                new Assert\NotNull(),
                new Assert\Length(['max'=> 65535]) // text type can hold up to 65535 characters
            ]
        ];

        $this->setFieldsWithConstraints($builder, $fieldsWithConstraints);
    }

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults([
            'data_class' => Task::class,
            'csrf_protection' => false,
        ]);
    }
}
