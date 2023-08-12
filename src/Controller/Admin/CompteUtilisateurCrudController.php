<?php

namespace App\Controller\Admin;

use App\Entity\CompteUtilisateur;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class CompteUtilisateurCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return CompteUtilisateur::class;
    }

    /*
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('title'),
            TextEditorField::new('description'),
        ];
    }
    */
}
