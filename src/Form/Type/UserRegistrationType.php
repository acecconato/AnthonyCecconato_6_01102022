<?php

namespace App\Form\Type;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserRegistrationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                'attr' => [
                    'placeholder' => 'Adresse email',
                ],
            ])
            ->add('username', TextType::class, [
                'attr' => [
                    'placeholder' => "Nom d'utilisateur",
                ],
            ])
            ->add('plainPassword', PasswordType::class, [
                'attr' => [
                    'placeholder' => 'Mot de passe',
                ],
                'trim' => true,
                'always_empty' => false,
                'help' => 'Doit au moins contenir un chiffre, une minuscule, une majuscule et un caractère spécial',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
