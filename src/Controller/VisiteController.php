<?php

namespace App\Controller;

use App\Repository\VisiteRepository;
use App\Form\VisiteType;
use App\Entity\Visite;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormView;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class VisiteController extends AbstractController
{
    /*
    private $repository;
    public function __construct(VisiteRepository $repository)
    {
        $this->repository = $repository;
    }*/
    #[Route('/visite', name: 'app_visite')]
    public function index(ManagerRegistry $managerRegistry): Response
    {
        $visites = $managerRegistry->getRepository(Visite::class)->findAll();
        return $this->render('visite/index.html.twig', [
            'visites' => $visites
        ]);
    }
    #[Route('/add_visite', name: 'app_add_visite')]
    public function addVisite(ManagerRegistry $managerRegistry, Request $request): Response
    {

        $visite = new Visite();
        $form = $this->createForm(VisiteType::class, $visite);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $manager = $managerRegistry->getManager();
            $manager->persist($visite);
            $manager->flush();
            return $this->redirectToRoute('app_visite');
        } else {

            return $this->render('visite/add.html.twig', [
                'VisiteForm' => $form->createView()
            ]);
        }
    }

    #[Route('/update_visite/{id}', name: 'app_update_visite')]
    public function updateVisite(Visite $visite, ManagerRegistry $managerRegistry, Request $request): Response
    {
        //$visite = $this->repository->findOneById($id);
        $form = $this->createForm(VisiteType::class, $visite);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $manager = $managerRegistry->getManager();
            $visite = $form->getData();
            $manager->persist($visite);
            $manager->flush();
            return $this->redirectToRoute('app_visite');;
        } else
            return $this->render('visite/add.html.twig', [
                'VisiteForm' => $form->createView()
            ]);
    }
}
