<?php

namespace App\Controller;

use App\Entity\CompteUtilisateur;
use App\Entity\Employe;
use App\Form\EmployeType;
use App\Repository\EmployeRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class EmployeController extends AbstractController
{
    /*
    private $repository;

    public function __construct(EmployeRepository $repository)
    {
        $this->repository = $repository;
    }*/

    #[Route('/employe', name: 'app_employe')]
    public function index(ManagerRegistry $managerRegistry): Response
    {
        $employes = $managerRegistry->getRepository(Employe::class)->findAll();
        //$search = new SearchData();
        /*$form = $this->createForm(SearchType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {*/
        //$search->page = $request->query->getInt('page', 1);
        //$employes2 = $employeRepository->findBySearch($search);
        //return $this->render('employe/index.html.twig', [
        //'form' => $form,
        /*'employes' => $employes
        ]);*/
        //}
        return $this->render('employe/index.html.twig', [
            'employes' => $employes,
            //'SearchForm' => $form->createView()
        ]);
    }
    #[Route('/add_employe', name: 'app_add_employe')]
    public function addEmploye(UserPasswordHasherInterface $passwordHasher, ManagerRegistry $managerRegistry, Request $request): Response
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
