<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class AlreadyAffectedValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint)
    {
        /* @var $constraint \App\Validator\AlreadyAffected */
        $data = $this->context->getRoot()->getData();
        $CampStartDate = $data->getStartDate();
        $CampEndDate = $data->getEndDate();
        $campId = $data->getId();
        $animatorAlreadyAffected = false;
        foreach ($value as $animator) {
            $camps = $animator->getCamps();
            foreach ($camps as $camp) {
                $startDate = $camp->getStartDate();
                $endDate = $camp->getEndDate();
                $id = $camp->getId();
//                dump(!((($newCampStartDate > $startDate) && ($newCampStartDate > $endDate)) || (($newCampEndDate < $startDate) && ($newCampEndDate <$endDate))));
                if(!((($CampStartDate > $startDate) && ($CampStartDate > $endDate)) || (($CampEndDate < $startDate) && ($CampEndDate <$endDate)))){
                    if($campId != $id) {
                        $animatorAlreadyAffected = $animator->getFullName();
                    }
                };
            }
        }
        if (!$animatorAlreadyAffected) {
            return;
        }

        // TODO: implement the validation here
        $this->context->buildViolation($constraint->message)
            ->setParameter('{{ value }}', $animatorAlreadyAffected)
            ->addViolation();
    }
}
