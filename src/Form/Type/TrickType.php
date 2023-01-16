<?php

declare(strict_types=1);

namespace App\Form\Type;

use App\Entity\Group;
use App\Entity\Trick;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TrickType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom',
            ])
            ->add('cover', FileType::class)
            ->add('images', FileType::class, [
                'label' => 'Ajouter des images',
                'mapped' => false,
                'multiple' => true,
                'attr' => ['placeholder' => 'Déplacez ou sélectionnez des images depuis votre appareil'],
            ])

            ->add('videos', CollectionType::class, [
                'entry_type' => VideoType::class,
                'entry_options' => ['label' => false],
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false
            ])


            ->add('description', TextareaType::class, [
                'attr' => [
                    'rows' => 8,
                ],
            ])
            ->add('categories', EntityType::class, [
                'label' => 'Groupes',
                'attr' => ['placeholder' => 'Sélectionnez un ou plusieurs groupes'],
                'autocomplete' => true,
                'class' => Group::class,
                'multiple' => true,
                'tom_select_options' => [
                    'create' => true,
                    'createOnBlur' => true,
                    'delimiter' => ',',
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Trick::class,
        ]);
    }
}
