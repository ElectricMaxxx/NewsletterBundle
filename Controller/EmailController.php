<?php
/**
 * User: maximilian
 * Date: 11/2/13
 * Time: 7:33 AM
 * 
 */

namespace NewsletterBundle\Controller;

use NewsletterBundle\Entity\EmailSubscriber;
use NewsletterBundle\Entity\SubscriberGroup;
use NewsletterBundle\Exceptions\EmailSubscriberException;
use NewsletterBundle\Form\CreateEmailForm;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class EmailController extends  AbstractCrudController{

    /**
     * @Route("/edit/{id}",name="_email_edit")
     * @Template("NewsletterBundle:Email:edit.html.twig")
     * @ParamConverter("subscriber",class="NewsletterBundle:EmailSubscriber")
     *
     * @param \NewsletterBundle\Entity\EmailSubscriber $subscriber
     * @return array
     */
    public function editAction(EmailSubscriber $subscriber)
    {
        $form = $this->createForm(new CreateEmailForm(),$subscriber);
        $request = $this->getRequest();
        if($request->isMethod('POST'))
        {
            $form->submit($request);
            if($form->isValid())
            {
                $subscriber = $form->getData();
                $em = $this->getDoctrine()->getManager();
                $em->persist($subscriber);
                $em->flush();
                return $this->redirect($this->generateUrl('_email_list'));
            }
        }

        return array(
            'form'      => $form->createView(),
            'message'=>'hier updaten',
            'type'  => 'edit',
            'id'    => $subscriber->getId(),
            'title' => 'Einen Abonenten bearbeiten'
        );
    }

    /**
     * this method should show a list of all Email-Addresses, with buttons to delete, create or edit an item
     * @Route("/",name="_email_list" )
     * @Template("NewsletterBundle::list.html.twig")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $SubscriberRepository = $em->getRepository('NewsletterBundle:EmailSubscriber');
        $Subscriber = $SubscriberRepository->findAll();

        $head = array(
            'mail'  => array(
                'data_map'  => 'email',
                'label'     => 'Email-Adresse'
            ),
            'name'  => array(
                'data_map'  => 'firstname',
                'label'     => 'Name'
            ),
            'options'  => array(
                'data_map'  => 'options',
                'label'     => 'Optionen'
            )
        );

        return array(
            'title'     => 'Email-Adressen verwalten',
            'message'   => 'verwalte deine Mailadressen hier',
            'options'   => $this->defaultListOptions,
            'data'      => $this->dataToRowConvert($this->defaultListOptions['buttons'],$head,$Subscriber,'_email'),
            'head'      => $head
        );
    }

    /**
     * @Route("/new",name="_email_new" )
     * @Template("NewsletterBundle:Email:edit.html.twig")
     *
     */
    public function newAction()
    {
        $form = $this->createForm(new CreateEmailForm(),new EmailSubscriber);
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
                return $this->redirect($this->generateUrl('_email_list'));
            }
        }
        return array(
            'form'      => $form->createView(),
            'message'=>'neu erstellen',
            'type'  => 'create',
            'title' => 'Einen Abonenten erstellen'
        );
    }

    /**
     * @Route("/delete/{id}",name="_email_delete" )
     * @ParamConverter("subscriber",class="NewsletterBundle:EmailSubscriber")
     *
     *
     * @param \NewsletterBundle\Entity\EmailSubscriber $subscriber
     * @throws \NewsletterBundle\Exceptions\EmailSubscriberException
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteAction(EmailSubscriber $subscriber)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($subscriber);
        $em->flush();
        return $this->redirect($this->generateUrl('_email_list'));
    }

    /**
     * method to toggle the activation state of an EmailSubscriber
     * @Route("/active/{id}",name="_email_activate")
     * @ParamConverter("subscriber",class="NewsletterBundle:EmailSubscriber")
     *
     * @param \NewsletterBundle\Entity\EmailSubscriber $subscriber
     * @throws \NewsletterBundle\Exceptions\EmailSubscriberException
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function activateAction(EmailSubscriber $subscriber)
    {
        $em = $this->getDoctrine()->getManager();
        $actualActive = $subscriber->getActive();
        $newActiveState = $actualActive == 0 ? 1 : 0;
        $subscriber->setActive($newActiveState);
        $em->flush();
        return $this->redirect($this->generateUrl('_email_list'));
    }

} 