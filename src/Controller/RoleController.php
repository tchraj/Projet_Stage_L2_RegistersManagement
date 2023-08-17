<?php

namespace App\Controller;
use App\Form\RoleType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Role;
use Symfony\Component\HttpFoundation\Request;

class RoleController extends AbstractController
{
    #[Route('/role', name: 'app_role')]
    public function index(ManagerRegistry $managerRegistry): Response
    {
        $roles = $managerRegistry->getRepository(Role::class)->findAll();
        return $this->render('role/index.html.twig', [
            'roles' => $roles
        ]);
    }
    #[Route('/add_role', name: 'app_add_role')]
    public function addPiece(ManagerRegistry $managerRegistry, Request $request): Response
    {
        $role = new Role();
        $form = $this->createForm(RoleType::class, $role);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $manager = $managerRegistry->getManager();
            $manager->persist($role);
            $manager->flush();
            $this->addFlash("Succes", "Role ajouté avec succes");
            return $this->redirectToRoute('app_role');
        } else
            return $this->render('role/update.html.twig', [
                'RoleForm' => $form->createView()
            ]);
    }
    #[Route('/update_role/{id}', name: 'app_update_role')]
    public function updatePiece(Role $role, ManagerRegistry $managerRegistry, Request $request): Response
    {
        //$piece = $managerRegistry->getRepository(TypePiece::class, $piece);
        $form = $this->createForm(RoleType::class, $role);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $manager = $managerRegistry->getManager();
            $role = $form->getData();
            $manager->persist($role);
            $manager->flush();
            return $this->redirectToRoute('app_role');;
        } else
            return $this->render('role/add.html.twig', [
                'RoleForm' => $form->createView()
            ]);
    }
    #[Route('/delete_role/{id}', name: 'app_delete_role')]
    public function deletePiece(Role $role, ManagerRegistry $managerRegistry): Response
    {
        //$piece = $managerRegistry->getRepository(TypePiece::class, $piece);

        $manager = $managerRegistry->getManager();
        //faire une requete
        $manager->remove($role);
        //executer la requete
        $manager->flush();
        return $this->redirectToRoute('app_role');
    }
}
