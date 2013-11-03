<?php
/**
 * User: maximilian
 * Date: 11/3/13
 * Time: 7:34 AM
 * 
 */

namespace NewsletterBundle\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class CreateEmailForm extends AbstractType{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('email', 'email');
        $builder->add('first_name','text');
        $builder->add('last_name','text');
        $builder->add('description', 'textarea');
        $builder->add('save','submit');
    }

    /**
     * Returns the name of this type.
     *
     * @return string The name of this type
     */
    public function getName()
    {
        return 'create_email';
    }
}