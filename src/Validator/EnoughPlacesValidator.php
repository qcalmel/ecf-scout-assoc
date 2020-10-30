<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class EnoughPlacesValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint)
    {
        /* @var $constraint \App\Validator\EnoughPlaces */
        $data = $this->context->getRoot()->getData();
        $capacity = $data->getCapacity();
        $nbChildren = count($data->getChildren());
        dump($nbChildren);
        if ($capacity >= $nbChildren) {
            return;
        }


        $this->context->buildViolation($constraint->message)
            ->setParameter('{{ value }}', $capacity)
            ->addViolation();
    }
}
