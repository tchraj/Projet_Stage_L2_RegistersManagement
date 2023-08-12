<?php

namespace App\Controller\Admin;

use App\Entity\Employe;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class Employe2CrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Employe::class;
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
