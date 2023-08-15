<?php

namespace App\Controller;

use App\Entity\CompteUtilisateur;
use App\Entity\Employe;
use App\Form\EmployeType;
use App\Services\AppSendEmail;
use Doctrine\Persistence\ManagerRegistry;
use App\Repository\EmployeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/employe')]
class EmployeController extends AbstractController
{
    /*
    private $repository;

    public function __construct(EmployeRepository $repository)
    {
        $this->repository = $repository;
    }*/

    #[Route('/', name: 'app_employe')]
    public function index(ManagerRegistry $managerRegistry): Response
    {
        $employes = $managerRegistry->getRepository(Employe::class)->findAll();

        return $this->render('employe/index.html.twig', [
            'employes' => $employes,
            //'SearchForm' => $form->createView()
        ]);
    }
    #[Route('/actifs', name: 'app_employe_actifs')]
    public function listeEmployesActifs(ManagerRegistry $managerRegistry)
    {
        $manager = $managerRegistry->getManager();
        $employes = $manager->getRepository(Employe::class)->findBy(['visible' => true]);

        return $this->render('employe/index.html.twig', [
            'employes' => $employes,
        ]);
    }
    #[Route('/add', name: 'app_add_employe')]
    public function addEmploye(UserPasswordHasherInterface $passwordHasher, ManagerRegistry $managerRegistry, Request $request, AppSendEmail $appSendEmail): Response
    {
        $employe = new Employe();
        $form = $this->createForm(EmployeType::class, $employe);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $manager = $managerRegistry->getManager();
            $manager->persist($employe);
            $prenom = $employe->getPrenoms();
            $nom = $employe->getNom();
            $p1 = substr($prenom, 0, 2);
            $username = strtolower($p1 . "." . $nom);
            $compte = new CompteUtilisateur();
            $compte->setUsername($username);
            $longueur = 12;
            $caracteres = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ@#/_*&';
            $password = '';
            for ($i = 0; $i < $longueur; $i++) {
                $password .= $caracteres[random_int(0, strlen($caracteres) - 1)];
            }
            $hashedPassword = $passwordHasher->hashPassword(
                $compte,
                $password
            );
            $compte->setPassClair($password);
            $compte->setPassword($hashedPassword);
            $manager->persist($compte);
            $manager->flush();
            $employe->setCompteUtilisateur($compte);
            $manager->persist($employe);
            $manager->flush();
            $flag = $appSendEmail->sendUnique(
                "amanarodia@gmail.com",
                $employe->getEmail(),
                "RENSEIGNEMENT DES IDENTIFIANTS",
                "Bonjour Monsieur/Madame" .
                    $employe->getNom() . "  " .
                    $employe->getPrenoms() .
                    " Voici vos identifiants pour vous connecter
                  à l'application de gestion des registres de 
                  ORABANK TOGO: <br> Nom d'utilisateur:$username; <br>Mot de passe:$password",
                'alert.html.twig'
            );
            return $this->redirectToRoute('app_employe');
        } else
            return $this->render('employe/add.html.twig', [
                'EmployeForm' => $form->createView()
            ]);
    }
    #[Route('/update/{id}', name: 'app_update_employe')]
    public function UpdateEmploye(Employe $employe, ManagerRegistry $managerRegistry, Request $request): Response
    {
        $form = $this->createForm(EmployeType::class, $employe);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $manager = $managerRegistry->getManager();
            $employe = $form->getData();
            $manager->persist($employe);
            $manager->flush();
            return $this->redirectToRoute('app_employe');
        } else
            return $this->render('employe/update.html.twig', [
                'EmployeForm' =>  $form->createView()
            ]);
    }
    // #[Route('/delete/{id}', name: 'app_delete_employe')]
    // public function desactiverEmploye($id, ManagerRegistry $managerRegistry)
    // {
    //     $entityManager = $managerRegistry->getManager();
    //     $employe = $entityManager->getRepository(Employe::class)->find($id);

    //     if (!$employe) {
    //         throw $this->createNotFoundException('Employé introuvable');
    //     }
    //     $employe->setVisible(false);
    //     $employe->setActif(false);
    //     $entityManager->flush();
    //     return $this->redirectToRoute('app_employe_actifs');
    // }
    /* #[Route('/indexVisible', name: 'app_hide_employe')]
    public function listeEmployes(ManagerRegistry $managerRegistry)
    {
        $employes = $$managerRegistry->getRepository(Employe::class)->findBy(['visible' => true]);
        return $this->render('employe/index.html.twig', [
            'employes' => $employes,
        ]);
    } */
    #[Route('/indexVisible/{id}', name: 'app_hide_employe')]
    public function listeEmployes($id, ManagerRegistry $managerRegistry)
    {
        $manager = $managerRegistry->getManager();
        $employe = $manager->getRepository(Employe::class)->find($id);
        if (!$employe) {
            throw $this->createNotFoundException('Employé introuvable');
        }
        $employe->setVisible(false);
        $manager->flush();
        return $this->redirectToRoute('app_employe_actifs');
    }
    #[Route('/visites_effectuees/{id}', name: 'app_visites_effectuees')]
    public function visitesEffectuees(Employe $employe)
    {
        $visitesEffectuees = $employe->getVisiteeffectuee();
        return $this->render('employe/visites_effectuees.html.twig', [
            'visitesEffectuees' => $visitesEffectuees,
        ]);
    }
    #[Route('/visites_recues/{id}', name: 'app_visites_recues')]
    public function visitesRecues(Employe $employe)
    {
        $visitesRecues = $employe->getVisiteRecue();
        return $this->render('employe/visites_recues.html.twig', [
            'visitesRecues' => $visitesRecues,
        ]);
    }
    //   public function visitesRecues(ManagerRegistry $managerRegistry )
    //   {
    //     $managerRegistry->getManager();
    //     // On récupère l'EntityManager
    //     //via le service ManagerRegistry qui nous a été injecté dans la méthode du contrôleur
    //     $em=$managerRegistry->getRepository("App\Entity\Visite");
    //     //$visites= $em->findAll();
    //     /*
    //     * Je vais faire une requête pour recuperer les données de ma table Visite
    //     et je retournera un objet QueryBuilder
    //     avec toutes mes conditions préalablement définies
    //     */
    //     $queryBuilder =$em -> createQueryBuilder('v')
    //     ->select(['v','c']);
    //     //je veux que mon select soit composée d'une colonne de la table
    //     Visite ('v')
    //     ->join ('App\Entity\Employe c ','v.employeVisiteur = c ')
    //     ;
    //     $paginator  = new Paginator($queryBuilder,$fetchJoinCollection = true );
    //     $resultat = $paginator->paginate(
    //         10 , ['*'], null,[
    //             'defaultSortFieldName'=>'DateVisite',
    //             'defaultSortOrder'=>"DESC",]
    //             );
    //             dump($resultat);
    //             die;
    //             return $this->render('employe/index.html.twig',[
    //                 "visites"=>$resultat]);
    //             }
    //     }



    //   }
    /*
    #[Route('/update_employe/{id}', name: 'app_update_employe')]
    public function UpdateEmploye(Employe $employe, ManagerRegistry $managerRegistry, Request $request): Response
    {
        $form = $this->createForm(EmployeType::class, $employe);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $manager = $managerRegistry->getManager();
            $employe = $form->getData();
            $manager->persist($employe);
            $manager->flush();
            return $this->redirectToRoute('app_employe');
        } else
            return $this->render('employe/update.html.twig', [
                'EmployeForm' =>  $form->createView()
            ]);
    } */
}
