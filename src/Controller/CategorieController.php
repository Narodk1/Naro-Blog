<?php

namespace App\Controller;
use App\Repository\PostRepository;
use App\Repository\CategorieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\TagRepository;

class CategorieController extends AbstractController
{
    #[Route('/categories/{id}', name: 'app_categorie', requirements: ['id' => '\d+'], defaults: ['id' => null])]
    public function categoryPosts(PostRepository $postRepository,TagRepository $tagRepository,CategorieRepository $categorieRepository, int $id = null): Response
    {
        
        $tags = $tagRepository->findAll();

        if ($id !== null) {
            $categorie = $categorieRepository->find($id);
            $posts = $categorie ? $categorie->getPost() : [];
            $tag=$tagRepository->find($id);
        } else {
            $posts = $postRepository->findAll();
            $categorie = null;
        }
    
        $categories = $categorieRepository->findAll();
    
        return $this->render('Categorie/Categorie.html.twig', [
            'posts' => $posts,
            'categorie' => $categorie,
            'categories' => $categories,
            'tags' => $tags,
            

        ]);
    }
    
   
}    