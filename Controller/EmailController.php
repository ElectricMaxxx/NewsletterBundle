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
     * @Route("/edit/{id}",name="_email")
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
     * @Route("/list",name="_email")
     * @Template("NewsletterBundle::list.html.twig")
     */
    public function indexAction()
    {

        $options = array(
            'buttons' => array('create','edit','delete','activate')
        );
        return array(
            'options' => $options,
            'data'    => array(),
            'head'    => array(
                'mail'  => array(
                    'data_map'  => 'mail',
                    'label'     => 'Email-Adresse'
                ),
                'mail'  => array(
                    'data_map'  => 'name',
                    'label'     => 'Name'
                ),
                'mail'  => array(
                    'data_map'  => 'options',
                    'label'     => 'Optionen'
                )
            )
        );
    }

} 