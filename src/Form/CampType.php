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
        $entity=$builder->getData();
        $isAgeRangeModfiable = !($entity->getId());
        dump($isAgeRangeModfiable);
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
                'choice_label'=>'detailedName',
                'disabled'=>!$isAgeRangeModfiable
            ])
            ->add('animators',EntityType::class,[
                'label'=> 'Animateurs',
                'class'=>'App\Entity\Animator',
                'choice_label'=>'fullName',
                'multiple'=> true,
                'required'=>false
            ]);
        if($entity->getId() !== null){
            dump('test');
            $builder->add('children',EntityType::class,[
                'label'=>'Enfants Inscrits',
                'class'=>'App\Entity\Child',
                'choices'=> $entity->getAgeRange()->getChildren(),
                'choice_label'=>'fullName',
                'multiple'=> true,
                'required'=>false
            ]);
        }
        $builder->add('submit', SubmitType::class, [
            'label' => 'Valider'
        ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Camp::class,
        ]);
    }
}
