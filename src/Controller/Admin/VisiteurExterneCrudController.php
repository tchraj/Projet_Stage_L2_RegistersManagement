<?php

namespace App\Controller\Admin;

use App\Entity\VisiteurExterne;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Form\Type\TextEditorType;

class VisiteurExterneCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return VisiteurExterne::class;
    }
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('nom'),
            TextField::new('prenoms'),
            EmailField::new('email'),
            TextField::new('tel'),
        ];
    }
}
