<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TemplateController extends AbstractController
{

    #[Route('/', name: 'app_home')]
    public function index(): Response
    {
        //$search = $this->createForm(VisiteurExtType::class,[]);
        //$form = $this->createForm(SearchType::class);
        return $this->render('acceuil/index.html.twig', [
            //'Search' => $search->createView()
        ]);
    }
    /* public function search(Request $request, ManagerRegistry $managerRegistry)
    {
        $form = $this->createForm(SearchType::class);
        $form->handleRequest($request);
        $results = [];
        if ($form->isSubmitted() && $form->isValid()) {
            $keyword = $form->get('keyword')->getData();
            $results = $this->$managerRegistry->getRepository(VisiteurExterne::class)->findByKeyword($keyword);
        }

        return $this->render('your_template/search.html.twig', [
            'form' => $form->createView(),
            'results' => $results,
        ]);
    } */
}
