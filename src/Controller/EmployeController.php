<?php

namespace App\Controller;

use App\Entity\Employe;

use App\Form\EmployeType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Repository\EmployeRepository;

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
        return $this->render('employe/index.html.twig', [
            'employes' => $employes
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
            return $this->render('employe/update.html.twig', [
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
                'EmployeForm' => $form->createView()
            ]);
    }
    
}
