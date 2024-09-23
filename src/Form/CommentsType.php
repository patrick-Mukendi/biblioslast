<?php

namespace App\Form;

use App\Entity\Book;
use App\Entity\Comments;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CommentsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('email')
            ->add('createdAt', null, [
                'widget' => 'single_text'
            ])
            ->add('publishedAt', null, [
                'widget' => 'single_text'
            ])
            ->add('status')
            ->add('content')
            ->add('book', EntityType::class, [
                'class' => Book::class,
'choice_label' => 'id',
'multiple' => true,
            ])
            ->add('books', EntityType::class, [
                'class' => Book::class,
'choice_label' => 'id',
'multiple' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Comments::class,
        ]);
    }
}
