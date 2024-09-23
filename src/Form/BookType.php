<?php

namespace App\Form;

use App\Entity\Author;
use App\Entity\Book;
use App\Entity\Comments;
use App\Entity\Editor;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BookType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title')
            ->add('isbn')
            ->add('cover')
            ->add('editedAt', null, [
                'widget' => 'single_text'
            ])
            ->add('plot')
            ->add('pageNumber')
            ->add('status')
            ->add('comments', EntityType::class, [
                'class' => Comments::class,
'choice_label' => 'id',
'multiple' => true,
            ])
            ->add('authorBook', EntityType::class, [
                'class' => Author::class,
'choice_label' => 'id',
            ])
            ->add('commentBook', EntityType::class, [
                'class' => Comments::class,
'choice_label' => 'id',
'multiple' => true,
            ])
            ->add('editorBook', EntityType::class, [
                'class' => Editor::class,
'choice_label' => 'id',
            ])
            ->add('authorbook', EntityType::class, [
                'class' => Author::class,
'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Book::class,
        ]);
    }
}
