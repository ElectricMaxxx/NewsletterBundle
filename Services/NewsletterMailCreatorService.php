<?php
/**
 * User: maximilian
 * Date: 11/9/13
 * Time: 11:43 PM
 * 
 */

namespace NewsletterBundle\Services;


use NewsletterBundle\Entity\Email;
use NewsletterBundle\Entity\Newsletter;

class NewsletterMailCreatorService {

    /**
     * Depending on the settings in this newsletter, this creator will build a Email class with
     * the properties, that match to the newsletter
     *
     * @param Newsletter $newsletter
     * @return Email
     */
    public function build(Newsletter $newsletter)
    {
        $mail = new Email();


        return $mail;
    }
} 