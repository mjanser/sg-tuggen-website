<?php

/*
 * This file is part of the SgTuggen\ContactBundle
 *
 * (c) Martin Janser <martin@gogan.ch>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace SgTuggen\ContactBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ContactType extends AbstractType
{
    /**
     * {@inheritDoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name', null, array('label' => 'Name'));
        $builder->add('email', null, array('label' => 'E-Mail-Adresse'));
        $builder->add('subject', null, array('label' => 'Betreff'));
        $builder->add('body', 'textarea', array('label' => 'Mitteilung'));
    }

    /**
     * {@inheritDoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'SgTuggen\ContactBundle\Model\Message',
        ));
    }

    /**
     * {@inheritDoc}
     */
    public function getName()
    {
        return 'contact';
    }
}
