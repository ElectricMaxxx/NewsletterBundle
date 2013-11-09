<?php
/**
 * User: maximilian
 * Date: 11/8/13
 * Time: 10:53 PM
 * 
 */

namespace NewsletterBundle\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class NewsletterType extends AbstractType{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('title', 'text');
        $builder->add('headline', 'text');
        $builder->add('body', 'textarea');
        $builder->add('count','hidden');
        $builder->add('subscriber','entity',array(
            'class'     => 'NewsletterBundle:EmailSubscriber',
            'property'  => 'email',
            'multiple'  => true,
            'expanded'  => true
        ));
        $builder->add('subscriberGroups','entity',array(
            'class'   => "NewsletterBundle:SubscriberGroup",
            'property'  => 'title',
            'multiple'  => true,
            'expanded'=> true));
        $builder->add('save','submit');
    }

    /**
     * Returns the name of this type.
     *
     * @return string The name of this type
     */
    public function getName()
    {
        return 'newsletter';
    }
}