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
                    'class' => 'champ',
                ],
                
            ])
            ->add('motif', TextType::class, [
                'attr' => [
                    'color' => 'black',
                    'class' => 'champ',
                ]
            ])
            ->add('EmployeVisite', EntityType::class, ['class' => Employe::class, 'attr' => [
                'class' => 'champ',
            ]])
            ->add('typePiece', null, ['attr' => [
                'class' => 'champ',
            ]])
            ->add('NumPiece', null, ['attr' => [
                'class' => 'champ',
            ]])
            ->add(
                'typeVisiteur',
                ChoiceType::class,
                [
                    'label' => 'Type de visiteur',
                    'attr' => ['class' => 'champ'],
                    'choices' => [
                        'Visiteur externe' => 'Visiteur externe',
                        'Employe visiteur' => 'Employe visiteur',
                    ],
                    'mapped' => false,
                ]
            )
            ->add('visiteurExterne', EntityType::class, [
                'attr' => ['class' => 'champ'],

                'class' => VisiteurExterne::class,
                'required' => false,
            ])
            ->add('employeVisiteur', EntityType::class, [
                'attr' => ['class' => 'champ'],
                'class' => Employe::class,
                'required' => false,
            ])
            ->add("Envoyer", SubmitType::class, [
                'attr' => ['class' => 'soumettre']
            ]);
           
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