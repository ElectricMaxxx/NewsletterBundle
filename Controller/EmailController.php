<?php
/**
 * User: maximilian
 * Date: 11/2/13
 * Time: 7:33 AM
 * 
 */

namespace NewsletterBundle\Controller;

use NewsletterBundle\Entity\EmailSubscriber;
use NewsletterBundle\Exceptions\EmailSubscriberException;
use NewsletterBundle\Form\CreateEmailForm;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class EmailController extends  Controller{

    /**
     * @Route("/edit/{id}",name="_email_edit")
     * @Template("NewsletterBundle:Email:edit.html.twig")
     * @param $id
     * @throws \NewsletterBundle\Exceptions\EmailSubscriberException
     * @return array
     */
    public function editAction($id)
    {
        //get the right subscriber
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository("NewsletterBundle:EmailSubscriber");
        $subscriber = $repository->findOneBy(array('id'=>$id));
        if(!$subscriber)
        {
            throw new EmailSubscriberException(printf('Can not find the subscriber with id %id to delete it',$id));
        }
        $form = $this->get('form.factory')->create(new CreateEmailForm());
        $request = $this->getRequest();
        //get the datat either from post or from the fresh object from database
        $form->setData($subscriber);
        if($request->isMethod('POST'))
        {
            $form->submit($request);
            if($form->isValid())
            {
                $editedSubscriber = $form->getData();
                $em = $this->getDoctrine()->getManager();
                $em->persist($editedSubscriber);
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
        $SubscriberRepsitory = $em->getRepository('NewsletterBundle:EmailSubscriber');
        $Subscriber = $SubscriberRepsitory->findAll();

        $options = array(
            'buttons' => array(
                'create'=>array('label'=>'Neu erstellen','url_shortcut'=>'_new'),
                'edit'=>array('label'=>'Update','url_shortcut'=>'_edit'),
                'delete'=>array('label'=>'Löschen','url_shortcut'=>'_delete'),
                'activate'=>array('label'=>array(
                    '0'=>'Aktivieren',
                    '1'=>'Deaktivieren'
                    ),
                    'url_shortcut'=>'_activate'
                )
            )
        );

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
            'options'   => $options,
            'data'      => $this->dataToRowConvert($options['buttons'],$head,$Subscriber),
            'head'      => $head
        );
    }

    private function dataToRowConvert($options,$head,$data)
    {
        $rows = array();
        foreach($data as $set)
        {
            $row = array(
                'fields'    => array(),
                'options'   => array()
            );
            foreach($head as $headField)
            {
                if(method_exists($set,"get".ucfirst($headField['data_map'])))
                {
                    $row['fields'][] = $set->{"get".ucfirst($headField['data_map'])}();
                }
            }
            foreach($options as $optionKey => $option)
            {
                if($optionKey != 'create')
                {
                    if($optionKey == 'activate' && property_exists($set,'active'))
                    {
                        $row['options'][] = array(
                            'label' => $option['label'][$set->getActive()],
                            'path'  => $this->generateUrl("_email".$option['url_shortcut'],array('id'=>$set->getId()))
                        );
                    }
                    else
                    {
                        $row['options'][] = array(
                            'label' => $option['label'],
                            'path'  => $this->generateUrl("_email".$option['url_shortcut'],array('id'=>$set->getId()))
                        );
                    }
                }
            }
            $rows[] = $row;
            unset($row);
        }
        return $rows;
    }
    /**
     * @Route("/new",name="_email_new" )
     * @Template("NewsletterBundle:Email:edit.html.twig")
     */
    public function newAction()
    {
        $form = $this->get('form.factory')->create(new CreateEmailForm());
        $request = $this->getRequest();
        $form->setData(new EmailSubscriber());
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
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @throws \NewsletterBundle\Exceptions\EmailSubscriberException
     */
    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository("NewsletterBundle:EmailSubscriber");
        $subscriber = $repository->findOneBy(array('id'=>$id));
        if(!$subscriber)
        {
            throw new EmailSubscriberException(printf('Can not find the subscriber with id %id to delete it',$id));
        }
        $em->remove($subscriber);
        $em->flush();
        return $this->redirect($this->generateUrl('_email_list'));
    }

    /**
     * method to toggle the activation state of an EmailSubscriber
     * @Route("/active/{id}",name="_email_activate")
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @throws \NewsletterBundle\Exceptions\EmailSubscriberException
     */
    public function activateAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $SubscriberRepsitory = $em->getRepository('NewsletterBundle:EmailSubscriber');
        $Subscriber = $SubscriberRepsitory->findOneBy(array('id'=>$id));
        if(!$Subscriber){
            throw new EmailSubscriberException(printf('Can not find the subscriber with id %id to toggle its activation state',$id));
        }
        $actualActive = $Subscriber->getActive();
        $newActiveState = $actualActive == 0 ? 1 : 0;
        $Subscriber->setActive($newActiveState);
        $em->flush();
        return $this->redirect($this->generateUrl('_email_list'));
    }

} 