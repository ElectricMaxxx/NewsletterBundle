<?php
namespace NewsletterBundle\Entity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name"subscriber_group")
 *
 * Class SubscriberGroup
 * @package NewsletterBundle\Entity
 */
class SubscriberGroup {

    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     *
     * @var int
     */
    protected $id;

    /**
     * @ORM\Column(type="string",length=100)
     * @var string
     */
    protected $title;

    /**
     * @ORM\Column(type="text")
     *
     * @var
     */
    protected $description;

    /**
     * @ORM\MannyToManny(targetEntity="EmailSubscriber",mappedBy="groups")
     * @ORM\JoinTable(name="email_subscriber_groups")
     *
     * @var \Doctrine\Common\Collections\ArrayCollection
     */
    protected $subscriber;

    public function __construct()
    {
        $this->subscriber = new ArrayCollection();
    }
} 