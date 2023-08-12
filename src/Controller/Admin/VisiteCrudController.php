<?php

namespace App\Controller\Admin;

use App\Entity\Visite;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TimeField;

class VisiteCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Visite::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            DateField::new('DateVisite'),
            TimeField::new('HeureDeb'),
            TimeField::new('HeureFin'),
            TextField::new('motif'),
            TextField::new('EtatVisite'),
            TextField::new('typeVisiteur'),
            TextField::new('visiteurExterne'),
            TextField::new('employeVisiteur'),
            
        //     AssociationField::new('visiteurExterne', 'Visiteur Externe'),
        //     AssociationField::new('employeVisiteur', 'Employé Visiteur'),
        ];
    }
    public function persistEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        if ($entityInstance instanceof Visite) {
            $entityManager->persist($entityInstance);
            $entityManager->flush();

            // Vous pouvez également ajouter un message de succès ou une redirection si nécessaire
            $this->addFlash('success', 'La visite a été enregistrée avec succès.');
            $this->redirectToRoute('admin'); // Rediriger vers la page d'administration

        }
    }
}
