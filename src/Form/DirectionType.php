<?php

namespace App\Form;

use App\Entity\Direction;
use App\Entity\Filiale;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DirectionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(
                'NomDirection',
                null
            )
            ->add('filiale', EntityType::class, [
                'attr' => [
                    'placeholder' => 'choisir une filiale'
                ],
                'class' => Filiale::class
            ])
            ->add('Envoyer', SubmitType::class);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Direction::class,
        ]);
    }
}
