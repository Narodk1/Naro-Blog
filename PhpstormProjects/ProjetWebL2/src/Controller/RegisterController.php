<?php

namespace App\Controller;



use App\Entity\Utilisateur;
use App\Form\RegistrationFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class RegisterController extends AbstractController
{

    #[Route('/SignUp', name: 'app_register')]
    public function register(Request $request): Response
    {
        // Créer une nouvelle instance de l'entité User
        $user = new Utilisateur();

        // Créer le formulaire d'inscription
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        // Traiter le formulaire soumis
        if ($form->isSubmitted() && $form->isValid()) {
            // Encoder le mot de passe de l'utilisateur
            $hashedPassword = $this->passwordHasher->hashPassword($user, $user->getPassword());
            $user->setPassword($hashedPassword);

            // Enregistrer l'utilisateur en base de données
            $this->userRepository->save($user);

            // Rediriger l'utilisateur vers une page de confirmation ou d'accueil
            return $this->redirectToRoute('app_homepage');
        }

        // Afficher le formulaire d'inscription
        return $this->render('SignUp/SignUp.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }
}
