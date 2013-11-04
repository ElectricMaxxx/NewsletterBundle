<?php
/**
 * User: maximilian
 * Date: 11/2/13
 * Time: 7:33 AM
 * 
 */

namespace NewsletterBundle\Controller;

use NewsletterBundle\Form\CreateEmailForm;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class EmailController extends  Controller{

    /**
     * @Route("/edit/{id}",name="_email_edit")
     * @Template()
     * @param $id
     * @return array
     */
    public function editAction($id)
    {
        return array('message'=>"edit email with id: ".$id);
    }

    /**
     * this method should show a list of all Email-Addresses, with buttons to delete, create or edit an item
     * @Route("/",name="_email_list" )
     * @Template("NewsletterBundle::list.html.twig")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $SubscriberRepsitory = $em->getRepository('NewsletterBundle:EmailSubscriber');
        $Subscriber = $SubscriberRepsitory->findAll();

        foreach($Subscriber as $email)
        {
            print("Mail: ".$email->getEmail()."\n");
        }
        $options = array(
            'buttons' => array('create'=>true,'edit'=>true,'delete'=>true,'activate'=>true)
        );
        return array(
            'title'     => 'Email-Adressen verwalten',
            'message'   => 'verwalte deine Mailadressen hier',
            'options'   => $options,
            'data'      => $Subscriber,
            'head'      => array(
                'mail'  => array(
                    'data_map'  => 'mail',
                    'label'     => 'Email-Adresse'
                ),
                'name'  => array(
                    'data_map'  => 'name',
                    'label'     => 'Name'
                ),
                'options'  => array(
                    'data_map'  => 'options',
                    'label'     => 'Optionen'
                )
            )
        );
    }

    /**
     * @Route("/new",name="_email_new" )
     * @Template("NewsletterBundle:Email:edit.html.twig")
     */
    public function newAction()
    {
        $form = $this->get('form.factory')->create(new CreateEmailForm());
        $request = $this->getRequest();
        if($request->isMethod('POST'))
        {
            $form->submit($request);
            if($form->isValid())
            {
                $emailSubscriber = $form->getData();
                $em = $this->getDoctrine()->getManager();
                $em->persist($emailSubscriber);
                $em->flush();
                $this->redirect($this->generateUrl('_email_list'));
            }
        }
        return array(
            'form'      => $form->createView(),
            'message'=>'neu erstellen',
            'type'  => 'create',
            'title' => 'Einen Abonenten erstellen'
        );
    }

} 