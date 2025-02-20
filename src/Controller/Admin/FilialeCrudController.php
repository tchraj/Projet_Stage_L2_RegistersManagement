<?php

namespace App\Controller\Admin;

use App\Entity\Filiale;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class FilialeCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Filiale::class;
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
