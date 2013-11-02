<?php
/**
 * User: maximilian
 * Date: 11/2/13
 * Time: 7:33 AM
 * 
 */

namespace Newsletter\Controller;

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

        $options = array(
            'buttons' => array('create'=>true,'edit'=>true,'delete'=>true,'activate'=>true)
        );
        return array(
            'title'     => 'Email-Adressen verwalten',
            'message'   => 'verwalte deine Mailadressen hier',
            'options'   => $options,
            'data'      => array(),
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
        return array('message'=>'neu erstellen');
    }

} 