<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\PostRepository;
class ApiController extends AbstractController
{
    #[Route('/posts', name: 'api_post')]
    public function apiPosts(PostRepository $postRepository): Response
    {
        $posts = $postRepository->findAll();

        return $this->json($posts, Response::HTTP_OK, [], [
            'groups' => ['post']
        ]);
    }
}
