<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Vich\UploaderBundle\Form\Type\VichImageType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstName', TextType::class, [
                'label' => "Prenom"
            ])
            ->add('lastName', TextType::class, [
                'label' => "Nom"
            ])
            ->add('email', EmailType::class, [
                'label' => "email"
            ])

            ->add('imageFile', VichImageType::class, [
                'required' => true,
                'allow_delete' => false,
                'download_label' => true,
                'image_uri'  => false,
            ])

            ->add(
                'password',
                PasswordType::class,
                ['label' => "Mot de passe"]
            )
            ->add('submit', SubmitType::class, [
                'label' => 'Envoyer'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
