<?php

namespace App\Controller;

use App\Entity\TypePiece;
use App\Form\TypePieceType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TypePieceController extends AbstractController
{
    #[Route('/type_piece', name: 'app_type_piece')]
    public function index(ManagerRegistry $managerRegistry): Response
    {
        $pieces = $managerRegistry->getRepository(TypePiece::class)->findAll();
        return $this->render('type_piece/index.html.twig', [
            'pieces' => $pieces
        ]);
    }
    #[Route('/add_piece', name: 'app_add_piece')]
    public function addPiece(ManagerRegistry $managerRegistry, Request $request): Response
    {
        $piece = new TypePiece();
        $form = $this->createForm(TypePieceType::class, $piece);
        $form->handleRequest($request);
        //verifier si la requete a ete soumise
        //si oui 
        //ajouter la piece dans la base de données
        //rediriger vers la liste des pieces
        //afficher un message de succes
        //sinon
        //afficher le formulaire
        //message d'erreur
        if ($form->isSubmitted()) {
            $manager = $managerRegistry->getManager();
            $manager->persist($piece);
            $manager->flush();
            $this->addFlash("Succes", "Votre piece a ete ajoutée avec succes");
            return $this->redirectToRoute('app_type_piece');
        } else
            return $this->render('type_piece/update.html.twig', [
                'PieceForm' => $form->createView()
            ]);
    }
    #[Route('/update_piece/{id}', name: 'app_update_piece')]
    public function updatePiece(TypePiece $piece, ManagerRegistry $managerRegistry, Request $request): Response
    {
        //$piece = $managerRegistry->getRepository(TypePiece::class, $piece);
        $form = $this->createForm(TypePieceType::class, $piece);
        $form->handleRequest($request);
        //verifier si la requete a ete soumise
        //si oui 
        //ajouter la piece dans la base de données
        //rediriger vers la liste des pieces
        //afficher un message de succes
        //sinon
        //afficher le formulaire
        //message d'erreur
        if ($form->isSubmitted()) {
            $manager = $managerRegistry->getManager();
            $piece = $form->getData();
            $manager->persist($piece);
            $manager->flush();
            $this->addFlash("Succes", "Votre piece modifiée avec succes");
            return $this->redirectToRoute('app_type_piece');;
        } else
            return $this->render('type_piece/add.html.twig', [
                'PieceForm' => $form->createView()
            ]);
    }
    #[Route('/delete_piece/{id}', name: 'app_delete_piece')]
    public function deletePiece(TypePiece $piece, ManagerRegistry $managerRegistry): Response
    {
        //$piece = $managerRegistry->getRepository(TypePiece::class, $piece);

            $manager = $managerRegistry->getManager();
            //faire une requete
            $manager->remove($piece);
            //executer la requete
            $manager->flush();
            return $this->redirectToRoute('app_type_piece');
    }
}
