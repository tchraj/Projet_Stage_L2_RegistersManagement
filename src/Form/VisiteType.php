<?php

namespace App\Form;

use App\Entity\Employe;
use App\Entity\Visite;
use App\Entity\VisiteurExterne;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class VisiteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('DateVisite', DateType::class, [
                'input'  => 'datetime',
                'widget' => 'single_text',
            ])
            ->add('HeureDeb', TimeType::class, [
                'input'  => 'datetime',
                'widget' => 'single_text',
            ])
            ->add('HeureFin', TimeType::class, [
                'input'  => 'datetime',
                'widget' => 'single_text',
            ])
            ->add('motif', TextType::class, [
                'attr' => [
                    'color' => 'black'
                ]
            ])
            ->add(
                'EtatVisite',
                ChoiceType::class,
                [
                    'choices'  => [
                        'Accepté' => true,
                        'Refusé' => false,
                    ]
                ]
            )
            ->add('visiteurExterne', EntityType::class, [
                'class' => VisiteurExterne::class,
            ])
            ->add('EmployeVisiteur', EntityType::class, ['class' => Employe::class])
            ->add('EmployeVisite', EntityType::class, ['class' => Employe::class])
            ->add('Envoyer', SubmitType::class);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Visite::class,
        ]);
    }
}
