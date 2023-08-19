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
            ->add('HeureDeb', TimeType::class, [
                'input' => 'string',
                'widget' => 'single_text',
                'attr' => [
                    'min' => '06:00',
                ],
            ])
            // ->add('HeureFin', TimeType::class, [
            //     'attr' => ['class' => 'colonne'],
            //     'input'  => 'datetime',
            //     'widget' => 'single_text',
            // ])
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
                'required' => false, // Vous pouvez ajuster cette option en fonction de vos besoins
            ])
            ->add('employeVisiteur', EntityType::class, [
                'attr' => ['class' => 'colonne'],
                'class' => Employe::class,
                'required' => false, // Vous pouvez ajuster cette option en fonction de vos besoins
            ])
            ->add("Envoyer", SubmitType::class);
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
    }
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Visite::class,
        ]);
    }
}

//$nom = $builder->get("nomVisiteur");

        /* $typeVisiteur = $builder->get("typeVisiteur");
        if ($typeVisiteur == 'Visiteur externe') {
            $builder->add('visiteurExterne', EntityType::class, ['class' => VisiteurExterne::class]);
        } elseif ($typeVisiteur == 'Employe visiteur') {
            $builder->add('EmployeVisiteur', EntityType::class, ['class' => Employe::class]);
        }
        /*  ->add('visiteurExterne', EntityType::class, [
                'class' => VisiteurExterne::class,
            ]) */
        /* $formMofifier = function(FormFormInterface $form ,$TypeVisiteur){
                if ($TypeVisiteur == true) {
                    $form->add('EmployeVisiteur', EntityType::class, ['class' => Employe::class]);
                }else {
                    $form->add('visiteurExterne', EntityType::class, ['class' => VisiteurExterne::class]);
                }
            };
            $builder->get('TypeVisiteur')->addEventListener(
                FormEvents::POST_SUBMIT,
                function(FormEvent $event) use ($formMofifier){
                    $TypeVisiteur = $event->getForm()->getData();
                    $formMofifier($event->getForm()->getParent(),$TypeVisiteur);
                }
            ); */
