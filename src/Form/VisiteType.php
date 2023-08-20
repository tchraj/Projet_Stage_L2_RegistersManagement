<?php

namespace App\Form;

use App\Entity\Employe;
use App\Entity\Visite;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\FormBuilderInterface;
use App\Entity\VisiteurExterne;
use Symfony\Component\Form\Extension\Core\Type\ResetType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class VisiteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder

        
            // ->add('DateVisite', null, [
            //     'widget' => 'single_text',
            //     'label_attr' => ['class' => 'label'],
            //     'row_attr' => ['class' => 'form-group'],
            //     'attr' => [
            //         'class' => 'form-group',
            //     ]
            // ])
            
            // ->add('HeureFin', TimeType::class, [
            //     'attr' => ['class' => 'colonne'],
            //     'input'  => 'datetime',
            //     'widget' => 'single_text',
            // ])



            ->add('HeureDeb', TimeType::class, [
                'input' => 'datetime',
                'widget' => 'single_text',
                'attr' => [
                    'min' => '06:00',
                ],
            ])
            ->add('motif', TextType::class, [
                'attr' => [
                    'color' => 'black'
                ]
            ])
            ->add('EmployeVisite', EntityType::class, ['class' => Employe::class])
            ->add('typePiece')
            ->add('NumPiece')
            ->add(
                'typeVisiteur',
                ChoiceType::class,
                [
                    'label' => 'Type de visiteur',
                    'attr' => ['class' => 'colonne'],
                    'choices' => [
                        'Visiteur externe' => 'Visiteur externe',
                        'Employe visiteur' => 'Employe visiteur',
                    ],
                    'mapped' => false,
                ]
            )
            ->add('visiteurExterne', EntityType::class, [
                'attr' => ['class' => 'colonne'],

                'class' => VisiteurExterne::class,
                'required' => false, 
            ])
            ->add('employeVisiteur', EntityType::class, [
                'attr' => ['class' => 'colonne'],
                'class' => Employe::class,
                'required' => false, 
            ])
            ->add("Envoyer", SubmitType::class)
            ->add("Annuler", ResetType::class);
    }
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Visite::class,
        ]);
    }
}


// ->add(
        //     'EtatVisite',
        //     ChoiceType::class,
        //     [
        //         'attr' => ['class' => 'colonne'],

        //         'choices'  => [
        //             'Accepté' => "Accepté",
        //             'Refusé' => "Refusé"
        //         ]
        //     ]
        // );
        //->add('Envoyer', SubmitType::class)