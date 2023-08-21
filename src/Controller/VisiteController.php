<?php

namespace App\Controller;

use App\Form\VisiteType;
use App\Entity\Visite;
use App\Services\AppSendEmail;
use App\Form\LierVisiteType;
use App\Entity\VisiteurExterne;
use App\Repository\VisiteRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Employe;
use App\Form\UpdateVisiteType;
use DateTime;

#[Route('/visite')]

class VisiteController extends AbstractController
{
    private $repository;
    public function __construct(VisiteRepository $repository)
    {
        $this->repository = $repository;
    }
    #[Route('/', name: 'app_visite')]
    public function index(ManagerRegistry $managerRegistry): Response
    {
        $manager = $managerRegistry->getManager();
        $visite = new Visite();
        $form = $this->createForm(VisiteType::class, $visite);
        $visites = $managerRegistry->getRepository(Visite::class)->findAll();
        return $this->render('visite/index.html.twig', [
            'visites' => $visites,
            'VisiteForm' => $form->createView(),
            'employeVisiteur' => $manager->getRepository(Employe::class)->findAll(),
            'employeVisite' => $manager->getRepository(Employe::class)->findAll(),
            'visiteurExterne' => $manager->getRepository(VisiteurExterne::class)->findAll()

        ]);
    }
    #[Route('/add', name: 'app_add_visite')]
    public function addVisite(ManagerRegistry $managerRegistry, Request $request, AppSendEmail $appSendEmail): Response
    {
        $manager = $managerRegistry->getManager();
        $visite = new Visite();
        $form = $this->createForm(VisiteType::class, $visite);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $manager = $managerRegistry->getManager();
            $type = $form->get("typeVisiteur")->getData();
            $visite->setTypeVisiteur($type);
            $visite->setDateVisite(new DateTime('today'));
            $employeVisite = $visite->getEmployeVisite();
            $visite->setEmployeVisite($employeVisite);
            if ($type == "Employe visiteur") {
                $visiteur = $visite->getEmployeVisiteur();
                $visite->setEmployeVisiteur($visiteur);
                $visiteur->addVisiteeffectuee($visite);
            } elseif ($type == "Visiteur externe") {
                $visiteur = $visite->getVisiteurExterne();
                $visite->setVisiteurExterne($visiteur);
            }
            $employeVisite->addVisiteRecue($visite);
            if ($visite->getHeureDeb() < '07:00' || $visite->getHeureFin() > '20:00') {
                $this->addFlash("Error", "Les heures de travail sont censées etres comprises");
            }
            $manager->persist($visite);
            $manager->flush();
            $appSendEmail->sendUnique(
                "amanarodia@gmail.com",
                $employeVisite->getEmail(),
                "Nouvelle visite!",
                "Bonjour Monsieur/Madame " .
                    $employeVisite->getNom() . "  " .
                    $employeVisite->getPrenoms() .
                    " Vous avez une nouvelle visite!<br>Monsieur/Madame $visiteur aimerais vous visiter;Veuillez répondre pour ne pas lui garder longtemps",
                'alert.html.twig'
            );
            $this->addFlash("Succes", "Visite ajoutée avec succes!");
            return $this->redirectToRoute('app_visite');
        } else
            return $this->render('visite/add.html.twig', [
                'VisiteForm' => $form->createView()
            ]);
    }

    #[Route('/update_visite/{id}', name: 'app_update_visite')]
    public function updateVisite(Visite $visite, ManagerRegistry $managerRegistry, Request $request): Response
    {
        //$visite = $this->repository->findOneById($id);
        $form = $this->createForm(UpdateVisiteType::class, $visite);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $manager = $managerRegistry->getManager();
            $visite = $form->getData();
            if ($visite->getHeureDeb() < '07:00' || $visite->getHeureFin() > '20:00') {
                $this->addFlash("Error", "Les heures de travail sont censées etres comprises");
            }
            $manager->persist($visite);
            $manager->flush();
            return $this->redirectToRoute('app_visite');
        } else
            return $this->render('visite/update.html.twig', [
                'VisiteForm' => $form->createView()
            ]);
    }
    #[Route('/accept_visite/{id}', name: 'app_accept_visite')]
    public function acceptRefuse(Request $request, Visite $visite, ManagerRegistry $managerRegistry)
    {
        if ($request->isMethod('POST')) {
            $accepted = $request->request->get('accepted') === 'on';
            $visite->setEtatVisite($accepted);
            $visite->setEtatVisite(true);
            $heureFin = new \DateTime($request->request->get('heure_fin'));
            $visite->setHeureFin($heureFin);
        }
        $manager = $managerRegistry->getManager();
        $manager->persist($visite);
        $manager->flush();
        return $this->redirectToRoute('app_visite');
    }
    // public function updateEtatVisite(ManagerRegistry $managerRegistry,Request $request): JsonResponse
    // {
    //     $visiteId = $request->request->get('visite_id');
    //     $isChecked = $request->request->get('is_checked');
    //     $manager = $managerRegistry->getManager();
    //     $visite = $manager->getRepository(Visite::class)->find($visiteId);
    //     if (!$visite) {
    //         return new JsonResponse(['message' => 'Visite introuvable'], Response::HTTP_NOT_FOUND);
    //     }
    //     // Mettre à jour l'état de la visite
    //     $visite->setEtatVisite($isChecked);
    //     $manager->flush();

    //     return new JsonResponse(['message' => 'État de visite mis à jour']);
    // }
    #[Route('/lier/{id}', name: 'app_lier_visiteur')]
    public function lierVisiteur($id, ManagerRegistry $managerRegistry, Request $request, EntityManagerInterface $entityManager)
    {
        //$visiteur = $managerRegistry->getRepository(VisiteurExterne::class)->find($id);
        $manager = $managerRegistry->getManager();
        $visite = new Visite();
        $visite->setTypeVisiteur("Visiteur externe");
        $visite->setDefaultVisiteur($id, $entityManager);
        $visite->setDateVisite(new DateTime('today'));
        $form = $this->createForm(LierVisiteType::class, $visite);
        // $visiteur = $managerRegistry->getRepository(VisiteurExterne::class)->find($id);
        // $visite = new Visite();
        // $form = $this->createForm(LierVisiteType::class, $visite, [
        //     'default_visiteur' => $visiteur,
        // ]);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $manager = $managerRegistry->getManager();
            $manager->persist($visite);
            $manager->flush();
            return $this->redirectToRoute('app_visite');
        } else {
            return $this->render(
                'visite/lier.html.twig',
                ['VisiteForm' => $form->createView()]
            );
        }
    }
}
