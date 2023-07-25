<?php

namespace App\Controller;


use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class TemplateController extends AbstractController
{
   
    #[Route('/template', name: 'app_template')]
    public function index(): Response
    {
        return $this->render('template/template.html.twig');
    }
}
