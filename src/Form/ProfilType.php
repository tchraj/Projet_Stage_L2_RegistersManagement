<?php

namespace App\Form;

use App\Entity\Role;
use App\Entity\Profil;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class ProfilType extends AbstractType
{
    public function __construct(private UrlGeneratorInterface $url)
    {
    }
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nomProfil', TextType::class, ['label' => 'Nom du profil'])
            ->add('roles')
            ->add('Envoyer',SubmitType::class);
    }
    // SearchableEntityType::class, [
    //     'class' => Role::class,
    //     'search' => $this->url->generate('roles'),
    //     'label_property' => 'NomRole',
    //     'value_property' => 'id'
    // ]
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Profil::class,
        ]);
    }
}
