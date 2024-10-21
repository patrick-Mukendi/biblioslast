<?php

namespace App\Form;

use App\Entity\Author;
use App\Entity\Book;
use App\Entity\Editor;
use App\Enum\BookStatus;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EnumType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;

class BookType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Titre',
            ])
            ->add('isbn', TextType::class, [
                'label' => 'Code isbn',
            ])
            ->add('cover', UrlType::class, [
                'label' => 'Couverture',
            ])
            ->add('editedAt', DateType::class, [
                'widget' => 'single_text',
                'input' => 'datetime_immutable',
                'label' => 'Edité le',
            ])
            ->add('plot', TextareaType::class, [
                'label' => 'Description',
            ])
            ->add('pageNumber', NumberType::class, [
                'input' => 'number',
                'label' => 'Nombre de Page',
            ])
            ->add('status', EnumType::class, [
                'class' => BookStatus::class,
                'label' => 'Disponibilé',
            ])
            ->add('authors', EntityType::class, [
                'class' => Author::class,
                'choice_label' => 'name',
                'label' => 'Auteur',
            ])
            ->add('editor', EntityType::class, [
                'class' => Editor::class,
                'choice_label' => 'name',
                'label' => 'Editeur',
            ])
            ->add('certification', CheckboxType::class, [
                'mapped' => false,
                'label' => "Je certifie l'exactitude des informations fournies",
                'constraints' => [
                    new IsTrue(message: 'Vous devez cocher la case pour ajouter un livre.'),
                ],
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
