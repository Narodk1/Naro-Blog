<?php 
namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Post;
use App\Entity\Utilisateur;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixture extends Fixture
{
    public function __construct(
        private UserPasswordHasherInterface $hasher
    ) {
    }

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_Fr');

        // My user
        $user = new Utilisateur();
        $user->setEmail('youssefnaro@gmail.com')
            ->setUsername('yNaro')
            ->setPassword(
                $this->hasher->hashPassword($user, 'password')
            );

        $manager->persist($user);

        for ($i = 0; $i < 9; $i++) {
            $user = new Utilisateur();
            $user->setEmail($faker->email())
                ->setUsername($faker->userName())
                ->setPassword(
                    $this->hasher->hashPassword($user, 'password')
                );

            $manager->persist($user);
        }

        $manager->flush();
    }
}

