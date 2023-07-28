<?php

namespace App\Form;

use App\Entity\Employe;
use App\Entity\TypeVisiteur;
use App\Entity\Visite;
use App\Entity\VisiteurExterne;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EnumType;
use Symfony\Component\Form\Extension\Core\Type\RadioType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface as FormFormInterface;
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
            ->add('EmployeVisite', EntityType::class, ['class' => Employe::class])
            ->add(
                'typeVisiteur',
                ChoiceType::class,
                [
                    'label' => 'Vous etes',
                    'required' => true,
                    'choices' => [
                        'Visiteur externe' => false,
                        'Employe visiteur' => true,
                    ]
                ]
            );
        $typeVisiteur = $builder->get("typeVisiteur");
        if ($typeVisiteur == 'Visiteur externe') {
            $builder->add('visiteurExterne', EntityType::class, ['class' => VisiteurExterne::class]);
        } elseif ($typeVisiteur == 'Employe visiteur') {
            $builder->add('EmployeVisiteur', EntityType::class, ['class' => Employe::class]);
        }
        /*  ->add('visiteurExterne', EntityType::class, [
                'class' => VisiteurExterne::class,
            ]) */
        $builder
            ->add('Envoyer', SubmitType::class);


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
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Visite::class,
        ]);
    }
}
