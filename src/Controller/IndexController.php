<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class IndexController extends AbstractController
{
    #[Route('', name: 'app_index')]
    public function index(): Response
    {
        return $this->render('index/index.html.twig', [
            'controller_name' => 'IndexController',
        ]);
    }
    #[Route('about', name: 'app_about')]
    public function about(): Response
    {
        return $this->render('About/About.html.twig', [
            'controller_name' => 'IndexController',
        ]);
    }
    #[Route('/Contact', name: 'app_contact')]
    public function contact(): Response
    {
        return $this->render('Contact/Contact.html.twig', [
            'controller_name' => 'IndexController',
        ]);
    }
    #[Route('/Categorie', name: 'app_categorie')]
    public function categorie(): Response
    {
        return $this->render('Categorie/Categorie.html.twig', [
            'controller_name' => 'IndexController',
        ]);
    }
    #[Route('/Search', name: 'app_search')]
    public function search(): Response
    {
        return $this->render('Search-resultat/Search-post.html.twig', [
            'controller_name' => 'IndexController',
        ]);
    }
    #[Route('/SinglePost', name: 'app_single')]
    public function Snigle(): Response
    {
        return $this->render('Single-Post/Single-post.html.twig', [
            'controller_name' => 'IndexController',
        ]);
    }

}
