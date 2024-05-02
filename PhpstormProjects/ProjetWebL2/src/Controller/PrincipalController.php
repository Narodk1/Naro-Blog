<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class PrincipalController extends AbstractController
{
    #[Route('', name: 'app_index')]
    public function index(): Response
    {
        return $this->render('index/index.html.twig', [
            'controller_name' => 'PrincipalController',
        ]);
    }
    #[Route('about', name: 'app_about')]
    public function about(): Response
    {
        return $this->render('About/About.html.twig', [
            'controller_name' => 'PrincipalController',
        ]);
    }
    #[Route('/Categorie', name: 'app_categorie')]
    public function categorie(): Response
    {
        return $this->render('Categorie/Categorie.html.twig', [
            'controller_name' => 'PrincipalController',
        ]);
    }
    #[Route('/Search', name: 'app_search')]
    public function search(): Response
    {
        return $this->render('Search-resultat/Search-post.html.twig', [
            'controller_name' => 'PrincipalController',
        ]);
    }
    #[Route('/SinglePost', name: 'app_single')]
    public function Snigle(): Response
    {
        return $this->render('Single-Post/Single-post.html.twig', [
            'controller_name' => 'PrincipalController',
        ]);
    }

}
