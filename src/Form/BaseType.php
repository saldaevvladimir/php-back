<?php

declare(strict_types= 1);

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;

abstract class BaseType extends AbstractType {
    protected function setFieldsWithConstraints(FormBuilderInterface $builder, array $fieldsWithConstraints): void {
        foreach ($fieldsWithConstraints as $field => $constraints) {
            $builder->add($field, TextType::class, [
                'constraints' => $constraints,
            ]);
        }
    }

    public function customGetErrors($form): array {
        $errors = [];

        foreach ($form->getErrors() as $error) {
            $errors[$form->getName()][] = $error->getMessage();
        }

        foreach ($form as $child) {
            if (!$child->isValid()) {
                foreach ($child->getErrors() as $error) {
                    $errors[$child->getName()][] = $error->getMessage();
                }
            }
        }

        return $errors;
    }
}
