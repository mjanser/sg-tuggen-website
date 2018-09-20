<?php

namespace App\Form;

use App\Model\Message;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, ['label' => 'Name', 'required' => true])
            ->add('email', EmailType::class, ['label' => 'E-Mail-Adresse', 'required' => true])
            ->add('subject', TextType::class, ['label' => 'Betreff', 'required' => true])
            ->add('body', TextareaType::class, ['label' => 'Mitteilung', 'required' => true])
            ->add('send', SubmitType::class, ['label' => 'Absenden'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Message::class,
        ]);
    }
}
