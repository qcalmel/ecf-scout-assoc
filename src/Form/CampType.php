<?php

namespace App\Form;

use App\Entity\Camp;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CampType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name',TextType::class,[
                'label'=>'Nom du camp'
            ])
            ->add('startDate',DateType::class,[
                'label'=>'Date de début'
            ])
            ->add('endDate',DateType::class,[
                'label'=>'Date de fin'
            ])
            ->add('capacity',IntegerType::class,[
                'label'=>'Nombre de places'
            ])
            ->add('ageRange',EntityType::class,[
                'label'=> "Tranche d'age",
                'class'=>'App\Entity\AgeRange',
                'choice_label'=>'detailedName'
            ])
            ->add('animators',EntityType::class,[
                'label'=> 'Animateurs',
                'class'=>'App\Entity\Animator',
                'choice_label'=>'fullName',
                'multiple'=> true
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Valider'
            ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Camp::class,
        ]);
    }
}
