<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Post\Category;
use App\Repository\Post\PostRepository;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class CategoryFixtures extends Fixture implements DependentFixtureInterface
{



    public function __construct(
        private PostRepository $postRepository
    ) {
    }

    // problème de lancement de category avant post donc  implement 


    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr');



        $categories = [];
        for ($i = 0; $i < 10; $i++) {
            $category = new Category();
            $category->setName($faker->words(1, true) . ' ' . $i)
                ->setDescription(
                    mt_rand(0, 1) === 1 ? $faker->realText(254) : null
                );





            $manager->persist($category);
            $categories[] = $category;
        }

        $posts = $this->postRepository->findAll();
        // pas de post donc pas de catégorie


        foreach ($posts as $post) {

            for ($i = 0; $i < mt_rand(1, 5); $i++) {
                $post->addCategory($categories[mt_rand(0, count($categories) - 1)]);
            }
        }


        $manager->flush();
    }


    // implement DependentFixtureInterface
    // besoin que post soit chargé avant category
    public function getDependencies(): array
    {
        return [
            PostFixtures::class,
        ];
    }
}
