<?php

namespace App\DataFixtures;

use App\Entity\Categorie;
use App\Entity\Tag;
use App\Repository\PostRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class CategorieFixtures extends Fixture implements DependentFixtureInterface
{
    public function __construct(
        private PostRepository $postRepository
    ) {
    }

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');
        $posts = $this->postRepository->findAll();

        // Category
        $categories = [];
        for ($i = 0; $i < 10; $i++) {
            $category = new Categorie();
            $category->setNomCat($faker->words(1, true) . ' ' . $i)
                ->setDesc(
                    $faker->realText(150)
                );

            $manager->persist($category);
            $categories[] = $category;
        }

        foreach ($posts as $post) {
            for ($i = 0; $i < mt_rand(1, 5); $i++) {
                $post->addCategory(
                    $categories[mt_rand(0, count($categories) - 1)]
                );
            }
        }

        // Tag
        $tags = [];
        for ($i = 0; $i < 10; $i++) {
            $tag = new Tag();
            $tag->setName($faker->words(1, true) . ' ' . $i)
                ->setDescription(
                    $faker->realText(150)
                );

            $manager->persist($tag);
            $tags[] = $tag;
        }

        foreach ($posts as $post) {
            for ($i = 0; $i < mt_rand(1, 5); $i++) {
                $post->addTag(
                    $tags[mt_rand(0, count($tags) - 1)]
                );
            }

        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [PostFixtures::class];
    }
}
