<?php

namespace NewsletterBundle\Entity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use NewsletterBundle\Entity\EmailSubscriber;

/**
 * SubscriberGroup
 * todo create the validation for it
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="NewsletterBundle\Entity\SubscriberGroupRepository")
 */
class SubscriberGroup
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=100)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     */
    private $description;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     * @ORM\ManyToMany(targetEntity="NewsletterBundle\Entity\EmailSubscriber",inversedBy="groups")
     * @ORM\JoinTable(name="subscriber_group_subscriber")
     */
    private $subscriber;

    /**
     * simple identifier if an subscriber is activated (1) or or not
     * @var int
     * @ORM\Column(name="active", type="integer")
     */
    private $active = 0;


    /**
     * to have the endpoint to the mapped subscribers in the newsletter
     * @ORM\ManyToMany(targetEntity="NewsletterBundle\Entity\Newsletter", mappedBy="subscriberGroups")
     * @ORM\JoinTable(name="newsletter_groups")
     * @var ArrayCollection
     */
    private $newsletter;


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->subscriber = new ArrayCollection();
        $this->newsletter = new ArrayCollection();
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set title
     *
     * @param string $title
     * @return SubscriberGroup
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set description
     *
     *
     * @param string $description
     * @return SubscriberGroup
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }


    /**
     * Get subscriber
     *
     * @return array
     */
    public function getSubscriber()
    {
        return $this->subscriber;
    }


    /**
     * Add subscriber
     *
     * @param EmailSubscriber $subscriber
     * @return SubscriberGroup
     */
    public function addSubscriber(EmailSubscriber $subscriber)
    {
        $this->subscriber[] = $subscriber;
    
        return $this;
    }

    /**
     * Remove subscriber
     *
     * @param EmailSubscriber $subscriber
     */
    public function removeSubscriber(EmailSubscriber $subscriber)
    {
        $this->subscriber->removeElement($subscriber);
    }

    /**
     * Set active
     *
     * @param integer $active
     * @return SubscriberGroup
     */
    public function setActive($active)
    {
        $this->active = $active;
    
        return $this;
    }

    /**
     * Get active
     *
     * @return integer 
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * Add newsletter
     *
     * @param \NewsletterBundle\Entity\Newsletter $newsletter
     * @return SubscriberGroup
     */
    public function addNewsletter(\NewsletterBundle\Entity\Newsletter $newsletter)
    {
        $this->newsletter[] = $newsletter;
    
        return $this;
    }

    /**
     * Remove newsletter
     *
     * @param \NewsletterBundle\Entity\Newsletter $newsletter
     */
    public function removeNewsletter(\NewsletterBundle\Entity\Newsletter $newsletter)
    {
        $this->newsletter->removeElement($newsletter);
    }

    /**
     * Get newsletter
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getNewsletter()
    {
        return $this->newsletter;
    }

    /**
     * @param \Doctrine\Common\Collections\ArrayCollection $newsletter
     */
    public function setNewsletter(ArrayCollection $newsletter)
    {
        $this->newsletter = $newsletter;
    }


}