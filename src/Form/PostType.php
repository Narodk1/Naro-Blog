<?php
// src/Form/PostType.php

// src/Form/PostType.php

// src/Form/PostType.php
// src/Form/PostType.php

// src/Form/PostType.php

namespace App\Form;

use App\Entity\Post;
use App\Entity\Categorie;
use App\Entity\Tag;
use App\Form\ImagesType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PostType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre', TextType::class, [
                'label' => 'Titre',
                'attr' => ['class' => 'form-control']
            ])
            ->add('contenu', TextareaType::class, [
                'label' => 'Contenu',
                'attr' => ['class' => 'form-control']
            ])
            ->add('categories', EntityType::class, [
                'class' => Categorie::class,
                'choice_label' => 'nomCat',
                'multiple' => true,
                'expanded' => true,
                'attr' => ['class' => 'form-check']
            ])
            ->add('tags', EntityType::class, [
                'class' => Tag::class,
                'choice_label' => 'name',
                'multiple' => true,
                'expanded' => true,
                'attr' => ['class' => 'form-check']
            ])
            ->add('images', ImagesType::class, [
                'label' => false,
                'required' => false,
            ])
            ->add('save', SubmitType::class, [
                'label' => 'Create Post',
                'attr' => ['class' => 'btn btn-primary mt-3']
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Post::class,
        ]);
    }
}
