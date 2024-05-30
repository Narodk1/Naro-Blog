<?php
// src/Controller/TagController.php

namespace App\Controller;

use App\Repository\PostRepository;
use App\Repository\TagRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\CategorieRepository;

class TagController extends AbstractController
{
    #[Route('/tags/{id}', name: 'app_tag', requirements: ['id' => '\d+'])]
    public function tagPosts(PostRepository $postRepository,CategorieRepository $categorieRepository ,TagRepository $tagRepository, int $id): Response
    {
        {        $categories = $categorieRepository->findAll();

        $tag = $tagRepository->find($id);
        if (!$tag) {
            throw $this->createNotFoundException('Tag not found');
        }

        $posts = $tag->getPosts(); // Assuming a ManyToMany relationship where a Tag has many Posts

        return $this->render('tag/tag.html.twig', [
            'posts' => $posts,
            'tag' => $tag,
            'categories' => $categories,
        ]);
    }
}
}
