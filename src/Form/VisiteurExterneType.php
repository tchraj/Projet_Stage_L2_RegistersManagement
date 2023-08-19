<?php

namespace App\Form;

use App\Entity\VisiteurExterne;
use EasyCorp\Bundle\EasyAdminBundle\Field\TelephoneField;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class VisiteurExterneType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(
                'nom',
                null
            )
            ->add('prenoms', null)
            ->add('sexe', null)
            ->add('email', null, [
                'attr' => [
                    'placeholder' => 'nomprenom@gmail.com'
                ]
            ])
            ->add('tel', TelType::class, [])
            ->add('Creer', SubmitType::class);
    }
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => VisiteurExterne::class,
        ]);
    }
}
