<?php

namespace App\Form;

use App\Entity\Visite;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\VisiteurExterne;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LierVisiteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $defaultVisiteur = $options['default_visiteur'];
        $builder
            // ->add('DateVisite')
            ->add('motif', TextType::class)
            ->add('EmployeVisite')
            ->add('HeureDeb', TimeType::class, [
                'widget' => 'choice',
                'attr' => [
                    'min' => '06:00',
                ],
                
            ])
            ->add('typePiece',ChoiceType::class,[
                'choices' =>[
                    'Carte nationale d\'identité' => 'Carte nationale d\'identité',
                    'Passport' => 'Passport',
                    'Badge' => 'Badge'
                ]
            ])
            ->add('NumPiece')
            // ->add('VisiteurExterne', HiddenType::class, [
            //     'data' => $defaultVisiteur,
            // ])
            ->add('VisiteurExterne', EntityType::class, [
                'class' => VisiteurExterne::class,
                //'choice_label' => $defaultVisiteur->getNom(), // Remplacez par la propriété appropriée
                //'data' => , // Utilisez le visiteur par défaut ici
            ])
            // ->add('HeureFin', TimeType::class, [
            //     'input'  => 'datetime',
            //     'widget' => 'single_text',
            // ])
            // ->add(
            //     'EtatVisite',
            //     ChoiceType::class,
            //     [
            //         'choices'  => [
            //             'Accepté' => "Accepté",
            //             'Refusé' => "Refusé"
            //         ]
            //     ]
            //)
            ->add("Envoyer", SubmitType::class);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Visite::class,
            'default_visiteur' => null
        ]);
    }
}
