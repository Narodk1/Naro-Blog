<?php

namespace App\DataFixtures;

use App\Entity\Post;
use App\Entity\Utilisateur;
use App\Entity\Images;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;


class PostFixtures extends Fixture
{
    public function __construct(
        private UserPasswordHasherInterface $hasher
    ) {
    }
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        // Création d'un utilisateur
        $user = new Utilisateur();
        $user->setEmail('bernard.tef@gmail.com')
            ->setUsername('Bernard')
            ->setPassword(
                $this->hasher->hashPassword($user, 'password')
            );

        $manager->persist($user);

        for ($i = 0; $i <=8; $i++) {
            // Création d'un post
            $post = new Post();
            $post->setTitre($faker->words(4, true))
                ->setContenu($faker->realText(1800))
                ->setUtilisateur($user);

            // Création d'une image pour chaque post
            $image = new Images();
                $image->setImageName('post-sq-' . $i . '.jpg');
            $image->setImageSize($faker->numberBetween(1000, 5000));

            $post->setImages($image);
            $image->setPost($post);

            $manager->persist($image);
            $manager->persist($post);
        }

        $manager->flush();
    }
}
