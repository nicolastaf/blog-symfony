<?php

namespace App\Form;

use App\Entity\Post;
use App\Entity\Author;
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
            ->add('publishedAt',DateTimeType::class,[
                'label'=>'Date de publication',
                'attr' => [
                    'placeholder' => 'Date de publication'
                ],
                'widget'=> 'single_text'
            ])
            ->add('image')
            ->add('author', EntityType::class,[
                'class' => Author::class,
                'label' => 'Auteur',
                'attr' => [
                    'placeholder' => 'Auteur'
                ]
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
