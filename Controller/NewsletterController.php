<?php
/**
 * User: maximilian
 * Date: 11/8/13
 * Time: 10:10 PM
 * 
 */

namespace NewsletterBundle\Controller;
use NewsletterBundle\Entity\Email;
use NewsletterBundle\Entity\EmailSubscriber;
use NewsletterBundle\Exceptions\NewsletterException;
use NewsletterBundle\Form\NewsletterType;
use NewsletterBundle\Services\NewsletterMailCreatorService;
use NewsletterBundle\Services\NewsletterMailService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

use NewsletterBundle\Entity\Newsletter;

/**
 * This class is a simple CRUD Controller for the newsletter,
 * you can create, update, delete or list the newsletters.
 *
 * But it is possible to send them, if the user wants to send them
 * The Newsletter will contain in its basic form:
 * title + body which are simple strings/text
 * the title will get a possibility to replace some placeholders by firstName/lastName of the
 * mail addresses that are grouped by the SubscriberGroup
 *
 * After creating the mail body (simple string containing headline+text or a string rendered by a template)
 * the sendAction(), will send it as single mails to each mail that is in a group.
 *
 * Class NewsletterController
 * @package NewsletterBundle\Controller
 */
class NewsletterController extends AbstractCrudController{


    /**
     *this will simply show the newsletters, to edit/delete them
     * @Route("/",name="_newsletter_list")
     * @Template("NewsletterBundle::list.html.twig")
     *
     */
    public function indexAction(){
        $repository = $this->getDoctrine()->getRepository('NewsletterBundle:Newsletter');
        $newsletters = $repository->findAll();
        $head = array(
            'title'  => array(
                'data_map'  => 'title',
                'label'     => 'Titel d. Newsletters'
            ),
            'options'  => array(
                'data_map'  => 'options',
                'label'     => 'Optionen'
            )
        );

        /**
         * need to change the options this time
         * need to kick the active button and create a button for sending the newsletter
         */
        $options = $this->defaultListOptions;
        unset($options['buttons']['activate']);
        $options['buttons']['send'] = array(
          'label'           => 'Senden',
          'url_shortcut'    => '_send'
        );

        return array(
          'title'       => 'Alle Newsletter auf einem Blick',
          'message'     => 'Hier kannst du alle Newsletter ',
          'options'     => $options,
          'data'        => $this->dataToRowConvert($options['buttons'],$head,$newsletters,'_newsletter'),
          'head'      => $head,
          'basePath' => '_group'
        );
    }

    /**
     * this method will create a newsletter with all its properties
     * - creates a form from by the type and the object
     * -
     * @Template("NewsletterBundle:Newsletter:edit.html.twig")
     * @Route("/new",name="_newsletter_new")
     */
    public function createAction(){
        $form = $this->createForm(new NewsletterType(),new Newsletter());
        $request = $this->getRequest();
        if($request->isMethod('POST'))
        {
            $form->submit($request);
            if($form->isValid())
            {
                $newsletter = $form->getData();
                //persist the data
                $em = $this->getDoctrine()->getManager();
                $em->persist($newsletter);
                $em->flush();
                return $this->redirect($this->generateUrl('_newsletter_list'));
            }
        }
        return array(
            'title' => 'Newsletter erstellen',
            'message'=>'Hier kannst du einen neuen Newsletter erstellen',
            'type'  => 'create',
            'form'=>$form->createView()
        );
    }

    /**
     * this method will update a specific newsletter
     * will get the entity the old fashioned way: get it from repo instead of paramConverter
     * cause i wanna get some more relational objects and manager them
     *
     * @Route("/edit/{id}",name="_newsletter_edit")
     * @Template("NewsletterBundle:Newsletter:edit.html.twig")
     * @ParamConverter("newsletter",class="NewsletterBundle:Newsletter")
     *
     * @param \NewsletterBundle\Entity\Newsletter $newsletter
     * @throws \NewsletterBundle\Exceptions\NewsletterException
     * @return array|\Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function editAction(Newsletter $newsletter)
    {
        $form = $this->createForm(new NewsletterType(),$newsletter);
        $request = $this->getRequest();
        if($request->isMethod('POST'))
        {
            $form->submit($request);
            if($form->isValid())
            {
                $newsletter = $form->getData();
                $em = $this->getDoctrine()->getManager();
                $em->persist($newsletter);
                $em->flush();
                return $this->redirect($this->generateUrl('_newsletter_list'));
            }
        }
        return array(
            'id'        => $newsletter->getId(),
            'title'     => 'Einen Newsletter bearbeiten',
            'message' => 'Bearbeite hier deine Newsletter, setze einen Titel der dir hilft die Newsletter
                          auseinander zu halte. Wähle eine Überschrift und einen Text für deinen Newsletter.',
            'form'  => $form->createView(),
            'type' => 'edit'
        );
    }

    /**
     *
     * @Route("/delete/{id}",name="_newsletter_delete")
     * @ParamConverter("newsletter",class="NewsletterBundle:Newsletter")
     * @param Newsletter $newsletter
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteAction(Newsletter $newsletter){
        $em = $this->getDoctrine()->getManager();
        $em->remove($newsletter);
        $em->flush();
        return $this->redirect($this->generateUrl('_newsletter_list'));
    }

    /**
     * This method will send the complete Newsletter, this means
     * depending on the type it will render a Template or simply creates an "string" body part for the
     * mail. This method will need the mailer service
     *
     * @Route("/send/{id}",name="_newsletter_send")
     * @ParamConverter("newsletter",class="NewsletterBundle:Newsletter")
     *
     * @param Newsletter $newsletter
     * @return array
     */
    public function sendAction(Newsletter $newsletter){
        /** @var NewsletterMailService $mailService*/
        $mailService = $this->get('newsletter_mailer');
        /** @var NewsletterMailCreatorService  $mailCreatorService */
        $mailCreatorService = $this->get('newsletter_mail_creator');

        //build the mail that we will send, the "to" property will be set later in a loop
        $mail = $mailCreatorService->build($newsletter);


        $mailService->send($mail);
        exit;
        return array();
    }

} 