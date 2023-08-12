<?php

namespace App\Controller\Admin;

use App\Entity\Employe;
use App\Entity\Visite;
use App\Entity\VisiteurExterne;
use App\Entity\Direction;
use App\Entity\Filiale;
use App\Entity\Role;
use App\Entity\Profil;
use App\Entity\TypePiece;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\UserMenu;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

class DashboardController extends AbstractDashboardController
{
    public function __construct(private AdminUrlGenerator $adminUrlGenerator)
    {
    }

    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        $urlVisite = $this->adminUrlGenerator->setController(VisiteCrudController::class)
            ->generateUrl();
        $urlVisiteurs = $this->adminUrlGenerator->setController(VisiteurExterneCrudController::class)
            ->generateUrl();
        return $this->redirect($urlVisite);
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('GestionDesRegsitres');
    }

    public function configureUserMenu(UserInterface $user): UserMenu
    {
        return parent::configureUserMenu($user)
            // use the given $user object to get the user name
            ->setName($user->getUserIdentifier())
            // use this method if you don't want to display the name of the user
            ->displayUserName(false)
            ->addMenuItems([
                MenuItem::linkToRoute('Mon Profile', 'fa fa-id-card', '...', ['...' => '...']),
                MenuItem::linkToRoute('Settings', 'fa fa-user-cog', '...', ['...' => '...']),
                MenuItem::section(),
            ]);
    }

    public function configureMenuItems(): iterable
    {
        return [
            MenuItem::linkToDashboard('ORAGUEST', 'fa fa-home'),

            MenuItem::section(),
            MenuItem::subMenu('Employes', 'fas fa-user')->setSubItems([
                MenuItem::linkToCrud('Creer un employe', 'fas fa-plus', Employe::class)->setAction('new'),
                MenuItem::linktoRoute('Employes enregistrés', 'fas fa-eye', 'app_employe')
            ]),
            MenuItem::section(),
            MenuItem::subMenu('Profils', 'fa-solid fa-id-badge')->setSubItems([
                MenuItem::linkToCrud('Creer un profil', 'fas fa-plus', Profil::class)->setAction('new'),
                MenuItem::linktoRoute('Profils enregistrés', 'fas fa-eye', 'app_profil')
            ]),
            MenuItem::section(),
            MenuItem::subMenu('Filiales', 'fa-solid fa-globe')->setSubItems([
                MenuItem::linkToCrud('Creer un profil', 'fas fa-plus', Filiale::class)->setAction('new'),
                MenuItem::linktoRoute('Filiales enregistrées', 'fas fa-eye', 'app_filiale')
            ]),
            MenuItem::section(),
            MenuItem::subMenu('Roles', 'fa-solid fa-dice-d6')->setSubItems([
                MenuItem::linkToCrud('Creer un role', 'fas fa-plus', Role::class)->setAction('new'),
                MenuItem::linktoRoute('Roles enregistrés', 'fas fa-eye', 'app_role')
            ]),
            MenuItem::section(),
            MenuItem::subMenu('TypePiece', 'fa-regular fa-id-badge')->setSubItems([
                MenuItem::linkToCrud('Creer une piece', 'fas fa-plus', TypePiece::class)->setAction('new'),
                MenuItem::linktoRoute('pieces enregistrées', 'fas fa-eye', 'app_type_piece')
            ]),
            MenuItem::section(),
            MenuItem::subMenu('Directions', 'fas fa-house')->setSubItems([
                MenuItem::linkToCrud('Creer une direction', 'fas fa-plus', Direction::class)->setAction('new'),
                MenuItem::linktoRoute('Directions enregistrés', 'fas fa-eye', 'app_direction')
            ]),
            MenuItem::section(),
            MenuItem::subMenu('Visites', 'fas fa-calendar')->setSubItems([
                MenuItem::linkToCrud('Creer une visite', 'fas fa-plus', Visite::class)->setAction('new'),
                MenuItem::linktoRoute('Visites enregistrées', 'fas fa-eye', 'app_add_visite'),
            ]),
            MenuItem::section(),
            MenuItem::subMenu('Visiteurs externes', 'fas fa-user-plus')->setSubItems([
                MenuItem::linkToCrud('Creer un visiteur', 'fas fa-plus', VisiteurExterne::class)->setAction('new'),
                MenuItem::linktoRoute('Visiteurs enregistrées', 'fas fa-eye', 'app_visiteur_externe')
            ])
        ];
    }
}
