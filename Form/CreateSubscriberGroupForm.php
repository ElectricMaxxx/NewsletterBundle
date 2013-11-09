<?php
/**
 * User: maximilian
 * Date: 11/6/13
 * Time: 10:32 PM
 * 
 */

namespace NewsletterBundle\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CreateSubscriberGroupForm extends AbstractType{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('title', 'text');
        $builder->add('description', 'textarea');
        $builder->add('subscriber','entity',array(
            'class'     => 'NewsletterBundle:EmailSubscriber',
            'property'  => 'email',
            'multiple'  => true,
            'expanded'  => true
        ));
        $builder->add('active','hidden');
        $builder->add('save','submit');
    }


    /**
     * Returns the name of this type.
     *
     * @return string The name of this type
     */
    public function getName()
    {
        return 'subscriber_group';
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'NewsletterBundle\Entity\SubscriberGroup'
        ));
    }
}