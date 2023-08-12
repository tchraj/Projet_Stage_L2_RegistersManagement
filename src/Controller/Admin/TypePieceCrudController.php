<?php

namespace App\Controller\Admin;

use App\Entity\TypePiece;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class TypePieceCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return TypePiece::class;
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
