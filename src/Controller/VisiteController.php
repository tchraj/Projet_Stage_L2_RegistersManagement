<?php

namespace App\Controller;

use App\Form\VisiteType;
use App\Entity\Visite;
use App\Entity\VisiteurExterne;
use App\Repository\VisiteRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Employe;

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
    public function addVisite(ManagerRegistry $managerRegistry, Request $request): Response
    {
        $manager = $managerRegistry->getManager();
        $visite = new Visite();
        $form = $this->createForm(VisiteType::class, $visite);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $manager = $managerRegistry->getManager();
            $type = $form->get("typeVisiteur")->getData();
            $visite->setTypeVisiteur($type);
            $manager->persist($visite);
            //dd($visite->getVisiteurExterne());
            $manager->flush();
            $employeVisite = $visite->getEmployeVisite();
            $employeVisite->addVisiteRecue($visite);
            if ($visite->getTypeVisiteur() == "Employe visiteur") {
                $employeVisiteur = $visite->getEmployeVisiteur();
                $employeVisiteur->addVisiteeffectuee($visite);
            }
            $this->addFlash("Succes", "Visite ajoutée avec succes!");
            return $this->redirectToRoute('app_visite');
        } else
            return $this->render('visite/add.html.twig', [
                'VisiteForm' => $form->createView()
            ]);
        /*if ($form->isSubmitted() && $form->isValid()) {
            $manager = $managerRegistry->getManager();
            $nomVisiteur = $form->get('nomVisiteur')->getData();
            $isEmploye = $form->get('typeVisiteur')->getData() === 'Employe visiteur';
            if ($isEmploye) {
                // Vérifier si l'employé existe déjà
                $employe = $managerRegistry->getRepository(Employe::class)->findOneBy(['nom' => $nomVisiteur]);
                if (!$employe) {
                    $employe = new Employe();
                    $employe->setNom($nomVisiteur);
                    // On peut définir d'autres propriétés de l'employé ici si nécessaire
                }
                $visite->setEmployeVisiteur($employe);
            } else {
                // Vérifier si le visiteur externe existe déjà
                $visiteurExterne = $managerRegistry->getRepository(VisiteurExterne::class)->findOneBy(['nom' => $nomVisiteur]);
                if (!$visiteurExterne) {
                    $visiteurExterne = new VisiteurExterne();
                    $visiteurExterne->setNom($nomVisiteur);
                    // On peut définir d'autres propriétés du visiteur externe ici si nécessaire
                }
                $visite->setVisiteurExterne($visiteurExterne);
            }
            // Envoyer la notification par e-mail
            $nomVisiteur = $form->get('nomVisiteur')->getData();
            $employeEmail = $employe->getEmail();
            $subject = 'Nouvelle visite';
            $message = $this->renderView('email/visite_notification.html.twig', [
                'visiteur' => $visiteurExterne,
                'employe' => $employe
            ]);
            $SendMail->sendNotificationEmail($employeEmail, $subject, $message);

            // Redirection et autres traitements
            $manager->persist($visite);
            $manager->flush();*/
        //$manager->persist($visite);
        //si
        //Si le visiteur est externe on le rajoute a la liste des visiteurs externes
        //sinon il est employe
        // $visiteRecherchee = $manager->getRepository(Visite::class);
        // $trouve = $visite->getTypeVisiteur();
        // $type = $visiteRecherchee->findOneByTypeVisiteur($trouve);
        // $nomVisiteur = $visite->getNomVisiteur();
        // if ($type == "Visiteur externe") {
        //     $visiteurExterne = new VisiteurExterne();
        //     $visiteurExterne->setNom($nomVisiteur);
        //     $manager->persist($visiteurExterne);
        //     $manager->flush();
        // } elseif ($type == "Employe visiteur") {
        //     $employe = $managerRegistry->getRepository(Employe::class);
        //     $employes = $this->$employe->findByNom($nomVisiteur);
        //     if (empty($employes)) {
        //         $newEmploye = new Employe();
        //         $newEmploye->setNom($nomVisiteur);
        //         $manager->persist($newEmploye);
        //         $manager->flush();
        //     }
        //     $emp = $this->$visiteRecherchee->getEmploye();
        //     $emp->addVisiteeffectuee($visite);
        // }
        // //fin si
        // $manager->flush();
        //     return $this->redirectToRoute('app_visite');
        // } else {

        //     return $this->render('visite/add.html.twig', [
        //         'VisiteForm' => $form->createView()
        //     ]);
        // }
    }

    // #[Route('/update_visite/{id}', name: 'app_update_visite')]
    // public function updateVisite(Visite $visite, ManagerRegistry $managerRegistry, Request $request): Response
    // {
    //     //$visite = $this->repository->findOneById($id);
    //     $form = $this->createForm(VisiteType::class, $visite);
    //     $form->handleRequest($request);
    //     if ($form->isSubmitted()) {
    //         $manager = $managerRegistry->getManager();
    //         $visite = $form->getData();
    //         $manager->persist($visite);
    //         $manager->flush();
    //         return $this->redirectToRoute('app_visite');
    //     } else
    //         return $this->render('visite/update.html.twig', [
    //             'VisiteForm' => $form->createView()
    //         ]);
    // }
    #[Route('/update/{id}', name: 'app_update_visite')]
    public function updateVisite($id, ManagerRegistry $managerRegistry, Request $request)
    {
        $manager = $managerRegistry->getManager();
        $visite = $manager->getRepository(Visite::class)->find($id);
        if (!$visite) {
            throw $this->createNotFoundException('La visite n\'a pas été retrouvée');
        }
        if ($request->isMethod('POST')) {
            $visite->setDateVisite($request->get('DateVisite'));
            $visite->setHeureDeb($request->get('HeureDeb'));
            $visite->setHeureFin($request->get('HeureFin'));
            $visite->setTypeVisiteur($request->get('typeVisiteur'));
            $visite->setMotif($request->get('motif'));
            $employesVisiteursIds = $request->request->get('employeVisiteur');
            $employesVisiteurs = $manager->getRepository(Employe::class)->findBy(['id' => $employesVisiteursIds]);
            $visite->setEmployeVisiteur($employesVisiteurs);
            $employesVisitesIds = $request->request->get('EmployeVisite');
            $employesVisites = $manager->getRepository(Employe::class)->findBy(['id' => $employesVisitesIds]);
            $visite->setEmployeVisite($employesVisites);
            $visiteurExterneIds = $request->request->get('visiteurExterne');
            $visiteurExterne = $manager->getRepository(VisiteurExterne::class)->findBy(['id' => $visiteurExterneIds]);
            $visite->setVisiteurExterne($visiteurExterne);
            $visite->setEtatVisite($request->get('EtatVisite'));
            $manager->persist($visite);
            $manager->flush();
            return $this->redirectToRoute('app_visite');
        }
        return $this->render('visite/index.html.twig', [
            'visites' => $visite,
            'employeVisiteur' => $manager->getRepository(Employe::class)->findAll(),
            'employeVisite' => $manager->getRepository(Employe::class)->findAll(),
            'visiteurExterne' => $manager->getRepository(VisiteurExterne::class)->findAll()
        ]);
    }
    // public function EditVisite($id, ManagerRegistry $managerRegistry,VisiteRepository $rep, RequestStack $requestStack,TraitFormulaire $traitFormulaire ){
    //     $request = $requestStack->getMainRequest();
    // }
}
