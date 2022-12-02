<?php

namespace App\DataFixtures;


use Faker\Factory;
use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;




class UserFixtures extends Fixture
{
    public function __construct(
        private UserPasswordHasherInterface $passwordHasher
    ) {
    }



    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr');
        //    creation de l'adminitrateur
        $user = new User();
        $user->setEmail('Macron@gmail.com')
            ->setFirstName('Emmanuel')
            ->setLastName('Macron')
            ->setPassword($this->passwordHasher->hashPassword($user, 'password'))
            ->setRoles(['ROLE_ADMIN']);


        $manager->persist($user);




        // creation de 10 utilisateurs


        for ($i = 0; $i < 10; $i++) {
            $user = new User();
            $user->setEmail($faker->email)
                ->setFirstName($faker->firstName)
                ->setLastName($faker->lastName)
                ->setPassword($this->passwordHasher->hashPassword($user, 'password'));






            $manager->persist($user);
        }


        $manager->flush();
    }
}
