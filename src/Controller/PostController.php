<?php

namespace App\Controller;

use App\Repository\PostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\CategorieRepository;
use App\Repository\TagRepository;
use App\Repository\UtilisateurRepository;
use App\Entity\Commentaire;
use App\Form\CommentaireType;
use App\Form\PostType;

use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;
use App\Entity\Post;
class PostController extends AbstractController
{
    #[Route('', name: 'app_index')]
    public function index(Request $request,PostRepository $postRepository, CategorieRepository $categorieRepository): Response
    {
    

        // Récupérer le dernier post
        $latestPost = $postRepository->findOneBy([], ['createdAt' => 'DESC']);

        // Récupérer toutes les catégories
        $categories = $categorieRepository->findAll();

        // Récupérer tous les autres posts (sans le dernier post)
        $posts = $postRepository->findBy([], ['createdAt' => 'DESC']);
        $otherPosts = [];
        foreach ($posts as $post) {
            if ($post->getId() !== $latestPost->getId()) {
                $otherPosts[] = $post;
            }
        }

        return $this->render('index/index.html.twig', [
            'latestPost' => $latestPost,
            'posts' => $otherPosts,
            'categories' => $categories,

        ]);
    }

    
    #[Route('/SinglePost/{id}', name: 'app_single', methods: ['GET', 'POST'])]
    public function show(Request $request, PostRepository $postRepository, TagRepository $tagRepository, int $id, CategorieRepository $categorieRepository, EntityManagerInterface $entityManager, Security $security): Response
    {
        $categories = $categorieRepository->findAll();
        $tags = $tagRepository->findAll();
        $post = $postRepository->find($id);

        if (!$post) {
            throw $this->createNotFoundException('The post does not exist');
        }

        $comment = new Commentaire();
        $form = $this->createForm(CommentaireType::class, $comment);
        $form->handleRequest($request);

        // Vérifiez si le formulaire a été soumis
        if ($form->isSubmitted()) {
            // Vérifiez si l'utilisateur est connecté
            $user = $security->getUser();
            if (!$user) {
                return $this->redirectToRoute('app_login');
            }

            // Si l'utilisateur est connecté et que le formulaire est valide
            if ($form->isValid()) {
                $comment->setPost($post);
                $comment->setUtilisateur($user);
                $entityManager->persist($comment);
                $entityManager->flush();

                return $this->redirectToRoute('app_single', ['id' => $post->getId()]);
            }
        }

        return $this->render('Single-Post/Single-post.html.twig', [
            'post' => $post,
            'categories' => $categories,
            'tags' => $tags,
            'comment_form' => $form->createView(),
        ]);
    }
    #[Route('/post/new', name: 'app_new')]
    public function new(Request $request, EntityManagerInterface $entityManager,CategorieRepository $categorieRepository): Response
    {        $categories = $categorieRepository->findAll();

        

        $post = new Post();
        $form = $this->createForm(PostType::class, $post);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Vérifiez si l'utilisateur est connecté
            if (!$this->getUser()) {
                // Redirige vers la page de connexion
                return $this->redirectToRoute('app_login');
            }

            $post->setUtilisateur($this->getUser()); // Associe l'utilisateur connecté au post

            // Persister l'image associée
            if ($post->getImages()) {
                $post->getImages()->setPost($post);
                $entityManager->persist($post->getImages());
            }

            // Persister les catégories
            foreach ($post->getCategories() as $category) {
                $category->addPost($post);
            }

            // Persister les tags
            foreach ($post->getTags() as $tag) {
                $tag->addPost($post);
            }

            $entityManager->persist($post);
            $entityManager->flush();

            // Récupérer le nom de l'image
            $imageName = $post->getImages() ? $post->getImages()->getImageName() : null;

            return $this->redirectToRoute('app_index'); // Redirige vers la liste des posts ou une autre page
        }

        return $this->render('post/new.html.twig', [
            'form' => $form->createView(),
            'categories' => $categories,
        ]);

    }

    #[Route('/commentaire/delete/{id}', name: 'app_comment_delete', methods: ['POST'])]
    public function deleteCommentaire(int $id, EntityManagerInterface $entityManager, Security $security): Response
    {
        $commentaire = $entityManager->getRepository(Commentaire::class)->find($id);

        if (!$commentaire) {
            throw $this->createNotFoundException('le commentaire n\'existe pas ');
        }

        $user = $security->getUser();
        if (!$user || $user !== $commentaire->getUtilisateur()) {
            throw $this->createAccessDeniedException('Vous n\'avez pas la permission de supprimer ce commentaire!');
        }

        $entityManager->remove($commentaire);
        $entityManager->flush();

        return $this->redirectToRoute('app_single', ['id' => $commentaire->getPost()->getId()]);
    }


    #[Route('/search', name: 'app_search')]
    public function search(Request $request, PostRepository $postRepository, CategorieRepository $categorieRepository, TagRepository $tagRepository): Response
    {
        $query = $request->query->get('query', '');
        if (empty($query)) {
            // Rediriger vers l'action index
            return $this->redirectToRoute('app_index');
        }
        $postsByTitle = $postRepository->createQueryBuilder('p')
            ->where('p.titre LIKE :query')
            ->setParameter('query', '%' . $query . '%')
            ->getQuery()
            ->getResult();

        $categories = $categorieRepository->createQueryBuilder('c')
            ->where('c.nomCat LIKE :query')
            ->setParameter('query', '%' . $query . '%')
            ->getQuery()
            ->getResult();

        $tags = $tagRepository->createQueryBuilder('t')
            ->where('t.name LIKE :query')
            ->setParameter('query', '%' . $query . '%')
            ->getQuery()
            ->getResult();

        $postsByCategory = [];
        foreach ($categories as $category) {
            foreach ($category->getPost() as $post) {
                if (!in_array($post, $postsByCategory)) {
                    $postsByCategory[] = $post;
                }
            }
        }

        $postsByTag = [];
        foreach ($tags as $tag) {
            foreach ($tag->getPosts() as $post) {
                if (!in_array($post, $postsByTag)) {
                    $postsByTag[] = $post;
                }
            }
        }

        $tags = $tagRepository->findAll();

        $posts = array_unique(array_merge($postsByTitle, $postsByCategory, $postsByTag), SORT_REGULAR);
        $categories = $categorieRepository->findAll();
        return $this->render('Search-resultat/Search-post.html.twig', [
            'query' => $query,
            'posts' => $posts,
            'categories' => $categories,
            'tags' => $tags,

        ]);
    }
}
       
