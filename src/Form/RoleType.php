<?php

namespace App\Form;

use App\Entity\Profil;
use App\Entity\Role;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RoleType extends AbstractType
{
    public function __construct(private UrlGeneratorInterface $url)
    {
    }
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('NomRole', TextType::class, ['label' => 'Nom du role'])
            ->add('description_role', TextType::class, [
                'label' => 'Description du role'
            ])
            /*->add('profils', SearchableEntityType::class, [
                'class' => Profil::class,
                'search' => $this->url->generate('profils'),
                'label_property' => 'nomProfil',

                'value_property' => 'id'
            ])*/
            ->add("submit", SubmitType::class, [
                'label' => 'Envoyer'
            ]);
    }
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Role::class,
        ]);
    }
}
