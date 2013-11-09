<?php
/**
 * User: maximilian
 * Date: 11/3/13
 * Time: 7:34 AM
 * 
 */

namespace NewsletterBundle\Form;


use Doctrine\Common\Collections\ArrayCollection;
use NewsletterBundle\Entity\SubscriberGroup;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CreateEmailForm extends AbstractType{

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('email', 'email');
        $builder->add('first_name','text');
        $builder->add('last_name','text');
        $builder->add('description', 'textarea');
        $builder->add('active','hidden');
        $builder->add('groups','entity',array(
            'class'   => "NewsletterBundle:SubscriberGroup",
            'property'  => 'title',
            'multiple'  => true,
            'expanded'=> true

        ));
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

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
             'data_class' => 'NewsletterBundle\Entity\EmailSubscriber'
        ));
    }
}