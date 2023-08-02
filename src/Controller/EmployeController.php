<?php

namespace App\Controller;

use App\Entity\Employe;

use App\Form\EmployeType;
use App\Form\SearchType;
use App\Models\SearchData;
use App\Repository\EmployeRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
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
    public function index(EmployeRepository $employeRepository, ManagerRegistry $managerRegistry, Request $request): Response
    {
        $employes = $managerRegistry->getRepository(Employe::class)->findAll();
        $search = new SearchData();
        $form = $this->createForm(SearchType::class, $search);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $search->page = $request->query->getInt('page', 1);
            $employes2 = $employeRepository->findBySearch($search);
            return $this->render('employe/index.html.twig', [
                'form' => $form,
                'employes2' => $employes2
            ]);
        }
        return $this->render('employe/index.html.twig', [
            'employes' => $employes,
            'SearchForm' => $form->createView()
        ]);
    }
    #[Route('/add_employe', name: 'app_add_employe')]
    public function addEmploye(ManagerRegistry $managerRegistry, Request $request): Response
    {
        $employe = new Employe();
        $form = $this->createForm(EmployeType::class, $employe);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $manager = $managerRegistry->getManager();
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
    /*     #[Route('/update_employe/{id}', name: 'app_update_employe')]
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
