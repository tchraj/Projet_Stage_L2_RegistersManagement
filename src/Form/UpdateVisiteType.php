<?php

namespace App\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\Visite;
use App\Entity\VisiteurExterne;
use App\Entity\Employe;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UpdateVisiteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('DateVisite', null, [
                'widget' => 'single_text',
                'label_attr' => ['class' => 'label'],
                'row_attr' => ['class' => 'form-group'],
                'attr' => [
                    'class' => 'form-group',
                ]
            ])
            ->add('EtatVisite')
            ->add('HeureDeb', TimeType::class, [
                'input' => 'datetime',
                'widget' => 'single_text',
                'attr' => [
                    'class' => 'champ',
                ],
                
            ])
            ->add('HeureFin', TimeType::class, [
                'input' => 'datetime',
                'widget' => 'single_text',
                'attr' => [
                    'class' => 'champ',
                ]
            ])
            ->add('motif', TextType::class, [
                'attr' => [
                    'color' => 'black',
                    'class' => 'champ',
                ]
            ])
            ->add('typePiece', null, ['attr' => [
                'class' => 'champ',
            ]])
            ->add('NumPiece', null, ['attr' => [
                'class' => 'champ',
            ]])
            ->add('EmployeVisite')
            ->add("Modifier", SubmitType::class, [
                'attr' => ['class' => 'soumettre']
            ])
            ->add('visiteurExterne', EntityType::class, [
                'attr' => ['class' => 'champ'],

                'class' => VisiteurExterne::class,
                'required' => false,
            ])
            ->add('employeVisiteur', EntityType::class, [
                'attr' => ['class' => 'champ'],
                'class' => Employe::class,
                'required' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Visite::class,
        ]);
    }
}
