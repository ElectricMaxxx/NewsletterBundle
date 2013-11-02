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
} 