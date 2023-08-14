<?php

namespace App\Controller;

use App\Entity\CompteUtilisateur;
use App\Form\CompteUtilisateurType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class CompteUtilisateurController extends AbstractController
{
    #[Route('/compte_utilisateur', name: 'app_compte_utilisateur')]
    public function index(ManagerRegistry $managerRegistry): Response
    {
        $comptes = $managerRegistry->getRepository(CompteUtilisateur::class)->findAll();
        return $this->render('compte_utilisateur/index.html.twig', [
            'comptes' => $comptes,
        ]);
    }
    #[Route('/add_compte', name: 'app_add_compte')]
    public function addCompte(ManagerRegistry $managerRegistry, Request $request): Response
    {
        $compte = new CompteUtilisateur();
        $form = $this->createForm(CompteUtilisateurType::class, $compte);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $manager = $managerRegistry->getManager();
            $manager->persist($compte);
            $manager->flush();
            $this->addFlash("Succes", "Compte crée avec succes");
            return $this->redirectToRoute('app_compte_utilisateur');
        } else
            return $this->render('compte_utilisateur/update.html.twig', [
                'CompteForm' => $form->createView()
            ]);
    }
    #[Route('/update_compte/{id}', name: 'app_update_compte')]
    public function updateCompte(CompteUtilisateur $compte, ManagerRegistry $managerRegistry, Request $request): Response
    {
        //$piece = $managerRegistry->getRepository(TypePiece::class, $piece);
        $form = $this->createForm(CompteUtilisateurType::class, $compte);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $manager = $managerRegistry->getManager();
            $compte = $form->getData();
            $manager->persist($compte);
            $manager->flush();
            $this->addFlash("Succes", "Compte modifié avec succes");
            return $this->redirectToRoute('app_compte_utilisateur');
        } else
            return $this->render('compte_utilisateur/add.html.twig', [
                'CompteForm' => $form->createView()
            ]);
    }
    #[Route('/delete_compte/{id}', name: 'app_delete_compte')]
    public function deleteCompte(CompteUtilisateur $compte, ManagerRegistry $managerRegistry): Response
    {
        //$piece = $managerRegistry->getRepository(TypePiece::class, $piece);
        $manager = $managerRegistry->getManager();
        //faire une requete
        $manager->remove($compte);
        //executer la requete
        $manager->flush();
        return $this->redirectToRoute('app_compte_utilisateur');
    }
}
