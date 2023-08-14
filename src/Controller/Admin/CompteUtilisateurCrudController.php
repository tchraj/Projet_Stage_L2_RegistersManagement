<?php

namespace App\Controller\Admin;

use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use App\Entity\CompteUtilisateur;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class CompteUtilisateurCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return CompteUtilisateur::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->onlyOnIndex()->setColumns(6),
            TextField::new('username', 'Nom Utilisateur')->setColumns(6),
            TextField::new('password', 'Mot de Passe')->setFormType(PasswordType::class)->onlyWhenCreating()->setColumns(6),
            TextEditorField::new('password', 'Passe')->onlyOnIndex()->setColumns(6),
            ChoiceField::new('roles', 'Roles')->setChoices(['Admin' => 'ROLE_ADMIN', 'Professeur' => 'ROLE_PROF', 'Etudiant' => 'ROLE_ETUDIANT', 'Chef de filière' => "ROLE_CHEF", "APOGE" => "ROLE_APOGE"])->allowMultipleChoices()->setColumns(6),
            #ImageField::new('imageFilename', 'Photos')->setFormType(FileUploadType::class)->setUploadDir('public/uploads')->setColumns(6),
        ];
    }
}
