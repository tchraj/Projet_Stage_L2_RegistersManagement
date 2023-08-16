<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Profil;
use App\Form\ProfilType;

#[Route('/profil')]
class ProfilController extends AbstractController
{
    #[Route('/', name: 'app_profil')]
    public function index(ManagerRegistry $managerRegistry): Response
    {
        $profils = $managerRegistry->getRepository(Profil::class)->findAll();
        return $this->render('profil/index.html.twig', [
            'controller_name' => 'ProfilController',
            'profils' => $profils,
        ]);
    }
    #[Route('/add', name: 'app_add_profil')]
    public function addProfil(ManagerRegistry $managerRegistry, Request $request): Response
    {
        $profil = new Profil();
        $form = $this->createForm(ProfilType::class, $profil);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $manager = $managerRegistry->getManager();
            $manager->persist($profil);
            $manager->flush();
            return $this->redirectToRoute('app_profil');
        } else
            return $this->render('profil/add.html.twig', [
                'ProfilForm' => $form->createView()
            ]);
    }
    #[Route('/update/{id}', name: 'app_update_profil')]
    public function updateProfil(Profil $profil, ManagerRegistry $managerRegistry, Request $request): Response
    {
        //$piece = $managerRegistry->getRepository(TypePiece::class, $piece);
        $form = $this->createForm(ProfilType::class, $profil);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $manager = $managerRegistry->getManager();
            $profil = $form->getData();
            $manager->persist($profil);
            $manager->flush();
            return $this->redirectToRoute('app_profil');;
        } else
            return $this->render('profil/update.html.twig', [
                'ProfilForm' => $form->createView()
            ]);
    }
    #[Route('/delete/{id}', name: 'app_delete_profil')]
    public function deleteProfil(Profil $profil, ManagerRegistry $managerRegistry): Response
    {
        //$profil = $managerRegistry->getRepository(TypePiece::class, $piece);
        $manager = $managerRegistry->getManager();
        //faire une requete
        $manager->remove($profil);
        //executer la requete
        $manager->flush();
        return $this->redirectToRoute('app_profil');
    }
    /* #[Route('/mes_visites', name: 'app_mes_visites')]
    public function MesVisites()
    {
        $user = $this->getUser(); 

        if ($user) {
            $employe = $user->getEmploye(); // Récupère l'employé associé à l'utilisateur

            if ($employe) {
                $nom = $employe->getNom();
                $prenom = $employe->getPrenom();
            } else {
                // L'utilisateur n'a pas d'employé associé, gérer le cas si nécessaire
            }
        } else {
            // L'utilisateur n'est pas connecté, gérer le cas si nécessaire
        }

        // ...
    } */
}
