<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\ActivityArea;
use App\Entity\ContractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('lastname')
            ->add('firstname')
            ->add('email')
            // ->add('roles')
            ->add('password')
            
            ->add('image')
        
            ->add('activity', EntityType::class, [
                "class" => ActivityArea::class,
                'choice_label' => 'name'
            ])
            ->add('contractType', EntityType::class, [
                "class" => ContractType::class,
                'choice_label' => 'name'
            ])
            ->add('contractStatus')
            
            ->add('contractEndDate', DateType::class,[
                'widget' => 'single_text',
                'attr' => ['class' => 'js-datepicker'],
                'required' => false,
                ])
            
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
