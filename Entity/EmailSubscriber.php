<?php
/**
 * User: maximilian
 * Date: 11/3/13
 * Time: 8:11 AM
 * 
 */

namespace NewsletterBundle\Entity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="email_subscriber")
 * Class EmailSubscriber
 * @package NewsletterBundle\Entity
 */
class EmailSubscriber   {

    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="Auto")
     * @var int
     */
    protected $id;

    /**
     * the simple email address of a subscriber
     * @ORM\Column(type="string",length=100)
     *
     * @var string
     */
    protected $email;

    /**
     * @ORM\Column(type="string",length=100)
     *
     * @var string
     */
    protected $firstName;

    /**
     * @ORM\Column(type="string",length=100)
     *
     * @var string
     */
    protected $lastName;

    /**
     * @ORM\Column(type="text")
     * @var string
     */
    protected $description;

    /**
     * @ORM\MannyToManny(targetEntity="SubscriberGroup",inversedBy="subscriber")
     * @var \Doctrine\Common\Collections\ArrayCollection
     */
    protected $groups;


    public function __construct()
    {
        $this->groups = new ArrayCollection();
    }

} 