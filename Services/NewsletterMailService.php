<?php
/**
 * User: maximilian
 * Date: 11/9/13
 * Time: 10:54 PM
 * 
 */

namespace NewsletterBundle\Services;

use NewsletterBundle\Entity\Email;
use NewsletterBundle\Entity\EmailSubscriber;

/**
 * this will be the service, which will do all sending mail things
 * - depending on the newsletter it will create the body with either title/text or a rendered Template
 * - depending on the config, it will append some articles or files
 * - mails can be send in single mode or all together
 * - behind the scenes this services calls the swiftmailer and do the sending process with them
 *
 * Class NewsletterMailService
 * @package NewsletterBundle\Services
 */
class NewsletterMailService {

    private $subscriber;

    private $email;

    public function __construct($mailer)
    {
        $this->mailer = $mailer;
    }

    public function send(Email $mail)
    {

    }
} 