<?php

namespace App\Controller;

use App\Entity\CompteUtilisateur;
use App\Form\EditProfilType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class ProfileController extends AbstractController
{
    #[Route('/profile', name: 'app_profile')]
    public function index(): Response
    {
        return $this->render('profile/index.html.twig');
    }

    #[Route('/edit_profile/{id}', name: 'app_edit_profile', methods: ['GET', 'POST'])]
    public function editProfil(ManagerRegistry $managerRegistry, Request $request, CompteUtilisateur $user, UserPasswordHasherInterface $hasher): Response
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('app_login');
        }
        if ($this->getUser() !== $user) {
            $this->addFlash("warning", "Vous n'etes pas connecté avec ce compte");
        }
        $form = $this->createForm(EditProfilType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($hasher->isPasswordValid($user, $form->getData()->getPassword())) {
                $manager = $managerRegistry->getManager();
                $user = $form->getData();
                $manager->persist($user);
                $manager->flush();
                $this->addFlash('succes', 'Votre profil a ete modifié avec succes');
                $this->redirectToRoute('app_profile');
            } else {
                $this->addFlash('warning', 'Votre mot de passe est incorrect!');
            }
            return $this->redirectToRoute('app_profile');
        }
        return $this->render('profile/edit.html.twig', [
            'ProfileForm' => $form->createView()
        ]);
    }

    /* #[Route('/edit_pass/{id}', name: 'app_edit_pass', methods: ['GET', 'POST'])]
    public function editPass(ManagerRegistry $managerRegistry, Request $request, CompteUtilisateur $user): Response
    {

    }
 */

 #[Route('/edit_password/{id}', name: 'app_edit_password', methods: ['GET', 'POST'])]
    public function editPassword(ManagerRegistry $managerRegistry, Request $request, CompteUtilisateur $user, UserPasswordHasherInterface $hasher): Response
    {
        return $this->render('reset_password/reset.html.twig');
    }
    public function index2(): Response
    {
        // usually you'll want to make sure the user is authenticated first,
        // see "Authorization" below
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        // returns your User object, or null if the user is not authenticated
        // use inline documentation to tell your editor your exact User class
        /** @var \App\Entity\User $user */
        $user = $this->getUser();

        // Call whatever methods you've added to your User class
        // For example, if you added a getFirstName() method, you can use that.
        return new Response($user->getEmail());
    }
}
