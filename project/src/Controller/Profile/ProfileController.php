<?php

namespace App\Controller\Profile;

use App\Entity\User;
use App\Form\UserType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[Route('/profile')]
class ProfileController extends AbstractController
{





    #[Route('/{id}', name: 'profile_index')]
    public function index(
        User $user,
        Request $request,
        EntityManagerInterface $em,
        UserPasswordHasherInterface $PasswordHasher
    ): Response {

        //  changement du password avec les accesseurs mutatateurs

        $user = $this->getUser();

        $userForm = $this->createForm(UserType::class, $user);
        $userForm->remove('password');
        $userForm->add('newPassword', PasswordType::class, ['label' => 'Nouveau mot de passe', 'required' => false]);
        $userForm->handleRequest($request);



        if ($userForm->isSubmitted() && $userForm->isValid()) {

            $newPassword = $user->getNewPassword();

            if ($newPassword) {

                $hash = $PasswordHasher->hashPassword($user, $newPassword);
                $user->setPassword($hash);
            }
            $em->flush();
            $this->addFlash('success', 'Modifications sauvegardées !');
        }



        return $this->render('pages/profile/index.html.twig', [
            'form' => $userForm->createView()
        ]);
    }
}
