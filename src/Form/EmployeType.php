<?php

namespace App\Form;

use App\Entity\Profil;
use App\Entity\Direction;
use App\Entity\CompteUtilisateur;
use App\Entity\Employe;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EmployeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(
                'nom',
                TextType::class
            )
            ->add(
                'prenoms',
                TextType::class,
            )
            ->add(
                'email',
                EmailType::class,
            )
            ->add(
                'tel',
                TextType::class,
            )
            ->add(
                'poste',
                TextType::class,
            )
            ->add(
                'direction',
                EntityType::class,
                [
                    'class' => Direction::class
                ],
            )
            ->add('actif', CheckboxType::class, [
                'label' => 'Actif',
                'required' => false,
            ])
            ->add('visible', HiddenType::class, [
                'data' => true
            ])
            ->add(
                'Envoyer',
                SubmitType::class
            );
    }
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Employe::class,
        ]);
    }
}
