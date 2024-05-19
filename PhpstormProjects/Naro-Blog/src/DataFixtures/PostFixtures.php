<?php

namespace App\DataFixtures;

use App\Entity\Post;
use App\Entity\Utilisateur;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class PostFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        $utilisateur = new Utilisateur();
        $utilisateur->setUsername($faker->lastName)
            ->setEmail($faker->email);
        $utilisateur->setPassword('test');

        $manager->persist($utilisateur);


        for ($i = 0; $i < 20; $i++) {
            $post = new Post();
            $post->setTitre($faker->words(4, true))
                ->setContenu($faker->realText(1800))
                ->setUtilisateur($utilisateur);

            $manager->persist($post);
        }

        $manager->flush();
    }

}
