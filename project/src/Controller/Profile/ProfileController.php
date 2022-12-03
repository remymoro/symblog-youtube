<?php

namespace App\Controller\Profile;

use App\Entity\User;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;





#[Route('/profile')]
class ProfileController extends AbstractController
{





    #[Route('/{id}', name: 'profile_index')]
    public function index(
        User $user
    ): Response {


         $user = $this->getUser();


         if($user->getId() !== $user->getId()) {
            return $this->redirectToRoute('home');
        }

       

        // modifier le profil







      



















        return $this->render('pages/profile/index.html.twig', [
            'controller_name' => 'ProfileController',
        ]);
    }
}
