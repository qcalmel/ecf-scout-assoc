<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class EnoughAnimatorsValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint)
    {
        /* @var $constraint \App\Validator\EnoughAnimators */
        $data = $this->context->getRoot()->getData();
        $capacity = $data->getCapacity();
        $nbChildrenByAnimator = $data->getAgeRange()->getNbChildrenByAnimator();
        $nbAnimatorMin = ceil($capacity / $nbChildrenByAnimator);
        if (count($value) >= $nbAnimatorMin) {
            return;
        }

        // TODO: implement the validation here
        $this->context->buildViolation($constraint->message)
            ->setParameter('{{ value }}', $nbAnimatorMin)
            ->addViolation();
    }
}
