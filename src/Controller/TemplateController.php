<?php

namespace App\Controller;

use App\Entity\VisiteurExterne;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Models\SearchData;
use App\Form\SearchType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;

class TemplateController extends AbstractController
{

    #[Route('/admin', name: 'app_template')]
    public function index(): Response
    {
        //$search = new SearchData();
        $form = $this->createForm(SearchType::class);
        return $this->render('template.html.twig', [
            //'SearchForm' => $form->createView()
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
