<?php

declare(strict_types= 1);

namespace App\Form;

use App\Entity\ProjectsGroup;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;


class ProjectsGroupType extends BaseType {
    public function buildForm(FormBuilderInterface $builder, array $options): void {
        $fieldsWithConstraints = [
            'name' => [
                new Assert\NotNull(),
                new Assert\Length(['min' => 3, 'max' => 128])
            ]
        ];

        $this->setFieldsWithConstraints($builder, $fieldsWithConstraints);
    }

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults([
            'data_class' => ProjectsGroup::class,
            'csrf_protection' => false,
        ]);
    }
}
