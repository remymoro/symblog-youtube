<?php

namespace App\DataFixtures;

use App\Repository\UserRepository;
use App\Repository\Post\PostRepository;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class LikeFixtures extends Fixture  implements DependentFixtureInterface
{



    function __construct(
        private PostRepository $postRepository,
        private UserRepository $userRepository
    ) {
    }




    public function load(ObjectManager $manager)
    {

        //  récupération de tout les Users 
        // récupération de tout les Posts

        $users = $this->userRepository->findAll();
        $posts = $this->postRepository->findAll();


        foreach ($posts as $post) {
            for ($i = 0; $i < mt_rand(0, 15); $i++) {
                $post->addLike(
                    $users[mt_rand(0, count($users) - 1)]
                );
            }
        }

        $manager->flush();
    }



    public function getDependencies(): array
    {
        return [
            UserFixtures::class,
            PostFixtures::class
        ];
    }
}
