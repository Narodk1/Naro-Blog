<?php
namespace App\DataFixtures;

use App\Entity\Commentaire;
use App\Repository\UtilisateurRepository;
use App\Repository\PostRepository;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Faker\Factory;


class CommentaireFixture extends Fixture implements DependentFixtureInterface
{
    public function __construct(
        private readonly PostRepository $postRepository,
        private readonly UtilisateurRepository $userRepository
    ) {
    }

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        $users = $this->userRepository->findAll();
        $posts = $this->postRepository->findAll();

        foreach ($posts as $post) {
            for ($i = 0; $i < mt_rand(0, 15); $i++) {
                $comment = new Commentaire();
                $comment->setContenu($faker->realText(150))
                    ->setUtilisateur($users[mt_rand(0, count($users) -1)])
                    ->setPost($post);

                $manager->persist($comment);
                $post->addCommentaire($comment);
            }
        }
        

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            UserFixture::class,
            PostFixtures::class
        ];
    }
}
