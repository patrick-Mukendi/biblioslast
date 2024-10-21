<?php

namespace App\Form;

use App\Entity\Author;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue as ConstraintsIsTrue;

class AuthorType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, ['label' => 'Nom complet'])
            ->add('dateOfBirth', DateType::class, [
                'label' => 'Né le',
                'widget' => 'single_text',
                'input' => 'datetime_immutable',
                'required' => false,
            ])
            ->add('dateOfDeath', null, [
                'label' => 'Mort le',
                'widget' => 'single_text',
                'input' => 'datetime_immutable',
                'required' => false,
            ])
            ->add('nationality', TextType::class, [
                'label' => 'Nationalité',
                'required' => false,
            ])
            ->add('certification', CheckboxType::class, [
                'mapped' => false,
                'label' => 'Je certifie que ses informations sont vraiex',
                'constraints' => [new ConstraintsIsTrue(message: 'Vous devez cocher cette case')],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Author::class,
        ]);
    }
}
