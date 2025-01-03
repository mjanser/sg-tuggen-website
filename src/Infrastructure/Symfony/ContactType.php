<?php

declare(strict_types=1);

namespace Infrastructure\Symfony;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * @extends AbstractType<Message>
 */
final class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, ['label' => 'Name', 'required' => true])
            ->add('email', EmailType::class, ['label' => 'E-Mail-Adresse', 'required' => true])
            ->add('subject', TextType::class, ['label' => 'Betreff', 'required' => true])
            ->add('body', TextareaType::class, ['label' => 'Mitteilung', 'required' => true])
            ->add('send', SubmitType::class, ['label' => 'Absenden'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Message::class,
        ]);
    }
}
