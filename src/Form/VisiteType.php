<?php

namespace App\Form;

use App\Entity\Employe;
use App\Entity\Visite;
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
                'input'  => 'string',
                'widget' => 'text'
            ])
            ->add('HeureDeb', TimeType::class, [
                'input' => 'string',
                'widget' => 'single_text'
            ])
            ->add('HeureFin', TimeType::class, [
                'input'  => 'string',
                'widget' => 'single_text',
            ])
            ->add('motif', TextType::class, [
                'attr' => [
                    'color' => 'black'
                ]
            ])
            ->add('EmployeVisite', EntityType::class, ['class' => Employe::class])
            ->add(
                'typeVisiteur',
                ChoiceType::class,
                [
                    'label' => 'Type de visiteur',
                    'choices' => [
                        'Visiteur externe' => "Visiteur externe",
                        'Employe visiteur' => "Employe visiteur",
                    ]
                ]
            )
            ->add('nomVisiteur', TextType::class)
            ->add(
                'EtatVisite',
                ChoiceType::class,
                [
                    'choices'  => [
                        'Accepté' => "Accepté",
                        'Refusé' => "Refusé"
                    ]
                ]
                    );

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
        $builder->add('Envoyer', SubmitType::class);


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
