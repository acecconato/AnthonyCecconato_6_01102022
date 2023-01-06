<?php

declare(strict_types=1);

namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\NotBlank;

class ResetPasswordRequestType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add('email', EmailType::class, [
            'label' => 'Adresse email',
            'attr' => ['placeholder' => 'Adresse email'],
            'required' => $options['required'],
            'constraints' => [
                new Email(message: "L'adresse email n'est pas valide"),
                new NotBlank(message: "L'adresse email ne doit pas être vide"),
            ],
        ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
    }
}
