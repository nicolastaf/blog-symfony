<?php

namespace App\Form;

use App\Entity\Post;
use App\Entity\Author;
use App\Entity\Category;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;

class PostType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title')
            ->add('body')
            ->add('nbLikes')
            ->add('publishedAt', DateTimeType::class,[
                'label'=>'Date de publication',
                'attr' => [
                    'placeholder' => 'Date de publication'
                ],
                'widget'=> 'single_text',
                'input' => 'datetime_immutable',
            ])
            ->add('createdAt', DateTimeType::class,[
                'label'=>'Date de création',
                'attr' => [
                    'placeholder' => 'Date de création'
                ],
                'widget'=> 'single_text',
                'input' => 'datetime_immutable',
            ])
            ->add('image')
            ->add('author', EntityType::class,[
                'class' => Author::class,
                'label' => 'Auteur',
                'attr' => [
                    'placeholder' => 'Auteur'
                ]
            ])
            ->add('updatedAt', DateTimeType::class,[
                'label'=>'Date de mise à jour',
                'attr' => [
                    'placeholder' => 'Date de mise à jour'
                ],
                'widget'=> 'single_text',
                'input' => 'datetime_immutable',
            ])
            ->add('categories', EntityType::class, [
                'class' => Category::class,
                'label' => 'Catégories',
                'choice_label' => 'name',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Post::class,
            'attr' => [
                'novalidate' => 'novalidate'
            ]
        ]);
    }
}
