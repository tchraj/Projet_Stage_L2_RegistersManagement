<?php

namespace App\Form;

use App\Entity\CompteUtilisateur;
use App\Entity\Profil;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CompteUtilisateurType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('username')
            // ->add('password')
            // ->add('passClair')
            ->add('profil', EntityType::class, ['class' => Profil::class])
            ->add('Envoyer',SubmitType::class);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => CompteUtilisateur::class,
        ]);
    }
}
