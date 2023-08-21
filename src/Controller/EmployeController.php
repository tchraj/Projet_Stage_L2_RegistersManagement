<?php

namespace App\Controller;

use App\Entity\CompteUtilisateur;
use App\Entity\Employe;
use App\Form\EmployeType;
use App\Services\AppSendEmail;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/employe')]
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
    #[Route('/add_employe', name: 'app_add_employe')]
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
            $compte->setEmploye($employe);
            $manager->persist($compte);
            $manager->flush();
            $employe->setCompteUtilisateur($compte);
            $manager->persist($employe);
            $manager->flush();
            $appSendEmail->sendUnique(
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
    }
    #[Route('/hide_employe/{id}', name: 'app_hide_employe')]
    public function desactiverEmploye($id, ManagerRegistry $managerRegistry)
    {
        $entityManager = $managerRegistry->getManager();
        $employe = $entityManager->getRepository(Employe::class)->find($id);

        if (!$employe) {
            throw $this->createNotFoundException('Employé introuvable');
        }
        $employe->setVisible(false);
        $entityManager->flush();
        return $this->redirectToRoute('app_employe_actifs');
    }
    #[Route('/visites_effectuees/{id}', name: 'app_visites_effectuees')]
    public function visitesEffectuees(Employe $employe, $id, ManagerRegistry $managerRegistry)
    {
        $manager = $managerRegistry->getManager();
        $employe = $manager->getRepository(Employe::class)->findOneBy(['id' => $id]);
        $visitesEffectuees = $employe->getVisiteeffectuee();
        return $this->render('employe/visites_effectuees.html.twig', [
            'visitesEffectuees' => $visitesEffectuees,
            'employe' => $employe
        ]);
    }
    #[Route('/visites_recues/{id}', name: 'app_visites_recues')]
    public function visitesRecues(Employe $employe, $id, ManagerRegistry $managerRegistry)
    {
        $manager = $managerRegistry->getManager();
        $employe = $manager->getRepository(Employe::class)->findOneBy(['id' => $id]);
        $visitesRecues = $employe->getVisiteRecue();
        return $this->render('employe/visites_recues.html.twig', [
            'visitesRecues' => $visitesRecues,
            'employe' => $employe
        ]);
    }

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
    // #[Route('/profil', name: 'app_profil_employe')]
    // public function profil(): Response
    // {
    //     // Récupérer l'utilisateur connecté (compte utilisateur)
    //     $user = $this->getUser();

    //     if ($user instanceof CompteUtilisateur) {
    //         // Récupérer l'employé associé au compte
    //         $employe = $user->getEmploye();

    //         // Vérifier si l'employé est présent
    //         if ($employe !== null) {
    //             $nom = $employe->getNom(); // Remplacez par la méthode appropriée
    //             $prenoms = $employe->getPrenoms();
    //             $email = $employe->getEmail();
    //             $poste = $employe->getPoste();
    //             $tel = $employe->getTel();
    //             $username = $user->getUsername();
    //             return $this->render('employe/detail.html.twig', [
    //                 'nom' => $nom,
    //                 'prenoms' => $prenoms,
    //                 'email' =>  $email,
    //                 'poste' => $poste,
    //                 'tel' => $tel,
    //                 'username' => $username
    //             ]);
    //         }
    //     }
    //     throw new NotFoundHttpException("L'employé n'existe pas");
    // }
    #[Route('/profil', name: 'app_profil_employe')]
    public function profil(): Response
    {
        // Récupérer l'utilisateur connecté (compte utilisateur)
        $user = $this->getUser();

        if ($user instanceof CompteUtilisateur) {
            // Récupérer l'employé associé au compte
            $employe = $user->getEmploye();

            // Vérifier si l'employé est présent
            if ($employe !== null) {
                $nom = $employe->getNom(); // Remplacez par la méthode appropriée
                $prenoms = $employe->getPrenoms();
                $email = $employe->getEmail();
                $poste = $employe->getPoste();
                $tel = $employe->getTel();
                $username = $user->getUsername();
                $visitesEffectuees = $employe->getVisiteeffectuee();
                $visitesRecues = $employe->getVisiteRecue();
                $nbVisitesE = $employe->nombreVisitesEffectuées();
                $nbVisitesR = $employe->nombreVisitesRecues();
                return $this->render('employe/detail.html.twig', [
                    'nom' => $nom,
                    'prenoms' => $prenoms,
                    'email' =>  $email,
                    'poste' => $poste,
                    'tel' => $tel,
                    'username' => $username,
                    'visitesE' => $visitesEffectuees,
                    'visitesR' => $visitesRecues,
                    'nombreVisE' => $nbVisitesE,
                    'nombreVisR' => $nbVisitesR
                ]);
            }
        }
        throw new NotFoundHttpException("L'employé n'existe pas");
    }
}
