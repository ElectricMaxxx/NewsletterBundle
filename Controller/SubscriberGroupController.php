<?php
/**
 * User: maximilian
 * Date: 11/6/13
 * Time: 9:50 PM
 * 
 */

namespace NewsletterBundle\Controller;
use NewsletterBundle\Entity\SubscriberGroup;
use NewsletterBundle\Exceptions\SubscriberGroupException;
use NewsletterBundle\Form\CreateSubscriberGroupForm;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class SubscriberGroupController extends AbstractCrudController{


    /**
     * this method will show a list of all groups, with the possibility to edit, delete or activate them
     * @Route("/",name="_group_list")
     * @Template("NewsletterBundle::list.html.twig")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository("NewsletterBundle:SubscriberGroup");
        $subscriberGroups = $repository->findAll();


        $head = array(
            'name'  => array(
                'data_map'  => 'title',
                'label'     => 'Name der Gruppe'
            ),
            'options'  => array(
                'data_map'  => 'options',
                'label'     => 'Optionen'
            )
        );
        return array(
            'title'     => 'Gruppenverwaltung',
            'message'   => 'Hier kannst du deine Email-Gruppen verwalten',
            'options'   => $this->defaultListOptions,
            'data'      => $this->dataToRowConvert($this->defaultListOptions['buttons'],$head,$subscriberGroups,'_group'),
            'head'      => $head,
            'basePath' => '_group'

        );

    }

    /**
     * @Route("/new",name="_group_new")
     * @Template("NewsletterBundle:Group:edit.html.twig")
     */
    public function createAction()
    {
        $form = $this->get('form.factory')->create(new CreateSubscriberGroupForm());
        $form->setData(new SubscriberGroup());
        $request = $this->getRequest();
        if($request->isMethod('POST')){
            $form->submit($request);
            if($form->isValid())
            {
                $group = $form->getData();
                $em = $this->getDoctrine()->getManager();
                $em->persist($group);
                $em->flush();
                return $this->redirect($this->generateUrl('_group_list'));
            }
        }
        return array(
            'title' => 'Email-Gruppe erstellen',
            'message'=>'Hier kannst du eine neue Email-Gruppe erstellen',
            'type'  => 'create',
            'form'=>$form->createView()
        );
    }


    /**
     * @Route("/edit/{id}",name="_group_edit")
     * @Template("NewsletterBundle:Group:edit.html.twig")
     * @ParamConverter("group",class="NewsletterBundle:SubscriberGroup")
     */
    public function editAction(SubscriberGroup $group)
    {
        $form = $this->createForm(new CreateSubscriberGroupForm(),$group);
        $request = $this->getRequest();

        if($request->isMethod('POST')){
            $form->submit($request);

            if($form->isValid())
            {
                $editedGroup = $form->getData();
                $em = $this->getDoctrine()->getManager();
                $em->persist($editedGroup);
                $em->flush();
                return $this->redirect($this->generateUrl('_group_list'));
            }
        }
        return array(
            'title'     => 'Eine Email-Gruppe bearbeiten',
            'message'   => 'Bearbeite hier deine Email-Gruppe',
            'form'      => $form->createView(),
            'type'      => 'edit',
            'id'        => $group->getId()
        );


    }

    /**
     * This method will delete a group.
     *
     * @Route("/delete/{id}",name="_group_delete")
     * @ParamConverter("group",class="NewsletterBundle:SubscriberGroup")
     */
    public function deleteAction(SubscriberGroup $group)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($group);
        $em->flush();
        return $this->redirect($this->generateUrl('_group_list'));
    }

    /**
     * This will toggle the activation state of a group,
     * only a activated group can be used for the newsletter
     *
     * @Route("/active/{id}",name="_group_activate")
     * @ParamConverter("group",class="NewsletterBundle:SubscriberGroup")
     */
    public function activateAction(SubscriberGroup $group){
        $actualState = $group->getActive();
        $group->setActive($actualState == 0 ? 1 : 0);

        $em = $this->getDoctrine()->getManager();
        $em->persist($group);
        $em->flush();
        return $this->redirect($this->generateUrl('_group_list'));
    }

} 