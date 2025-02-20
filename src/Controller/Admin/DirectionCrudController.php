<?php

namespace App\Controller\Admin;

use App\Entity\Direction;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class DirectionCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Direction::class;
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
