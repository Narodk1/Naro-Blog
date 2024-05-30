<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class PrincipalController extends AbstractController
{

    #[Route('about', name: 'app_about')]
    public function about(): Response
    {
        return $this->render('About/About.html.twig', [
            'controller_name' => 'PrincipalController',
        ]);
    }
    
   
   
}
