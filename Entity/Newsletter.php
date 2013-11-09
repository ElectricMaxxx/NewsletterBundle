<?php

namespace NewsletterBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Newsletter
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Newsletter
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
     * the body for a simple text mail or a complete rendered HTML-DOM which needs to be send.
     *
     * @var string
     *
     * @ORM\Column(name="body", type="string", length=255)
     */
    private $body;

    /**
     * The headline could contain some placeholders for {first_name} or {last_name}, which are
     * replaced
     *
     * @var string
     * @ORM\Column(name="headline", type="string", length=255)
     */
    private $headline;

    /**
     * To divide them in the list only
     * 
     * @ORM\Column(name="title", type="string", length=255)
     * @var string
     */
    private $title;

    /**
     * to get a list of subscribers, if the user wants to send a newsletter to some
     * subscriber only or wants to add them to existing lists
     *
     * @ORM\ManyToMany(targetEntity="NewsletterBundle\Entity\EmailSubscriber", mappedBy="newsletter")
     * @ORM\JoinTable(name="newsletter_subscriber")
     *
     * @var ArrayCollection
     */
    private $subscriber;

    /**
     * Made it as a collection. normally we would think one newsletter -> one group, but do not know what will
     * happen. By this we are able to merge several groups with some single subscribers.
     *
     * @ORM\ManyToMany(targetEntity="NewsletterBundle\Entity\SubscriberGroup", mappedBy="newsletter")
     * @ORM\JoinTable(name="newsletter_groups")
     *
     * @var ArrayCollection
     */
    private $subscriberGroups;

    /**
     * a property to store the information of the count of using this newsletter
     *
     * @ORM\Column(name="count", type="integer")
     * @var
     */
    private $count = 0;


    /**
     * Constructor to set the ArrayCollections
     */
    public function __construct()
    {
        $this->subscriber = new ArrayCollection();
        $this->subscriberGroups = new ArrayCollection();
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
     * Set body
     *
     * @param string $body
     * @return Newsletter
     */
    public function setBody($body)
    {
        $this->body = $body;
    
        return $this;
    }

    /**
     * Get body
     *
     * @return string 
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * Set headline
     *
     * @param string $headline
     * @return Newsletter
     */
    public function setHeadline($headline)
    {
        $this->headline = $headline;
    
        return $this;
    }

    /**
     * Get headline
     *
     * @return string 
     */
    public function getHeadline()
    {
        return $this->headline;
    }

    /**
     * Set title
     *
     * @param string $title
     * @return Newsletter
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
     * Set count
     *
     * @param integer $count
     * @return Newsletter
     */
    public function setCount($count)
    {
        $this->count = $count;
    
        return $this;
    }

    /**
     * Get count
     *
     * @return integer 
     */
    public function getCount()
    {
        return $this->count;
    }

    /**
     * Add subscriber
     *
     * @param \NewsletterBundle\Entity\EmailSubscriber $subscriber
     * @return Newsletter
     */
    public function addSubscriber(\NewsletterBundle\Entity\EmailSubscriber $subscriber)
    {
        $this->subscriber[] = $subscriber;
    
        return $this;
    }

    /**
     * Remove subscriber
     *
     * @param \NewsletterBundle\Entity\EmailSubscriber $subscriber
     */
    public function removeSubscriber(\NewsletterBundle\Entity\EmailSubscriber $subscriber)
    {
        $this->subscriber->removeElement($subscriber);
    }

    /**
     * Get subscriber
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getSubscriber()
    {
        return $this->subscriber;
    }

    /**
     * Add subscriberGroups
     *
     * @param \NewsletterBundle\Entity\SubscriberGroup $subscriberGroups
     * @return Newsletter
     */
    public function addSubscriberGroup(\NewsletterBundle\Entity\SubscriberGroup $subscriberGroups)
    {
        $this->subscriberGroups[] = $subscriberGroups;
    
        return $this;
    }

    /**
     * Remove subscriberGroups
     *
     * @param \NewsletterBundle\Entity\SubscriberGroup $subscriberGroups
     */
    public function removeSubscriberGroup(\NewsletterBundle\Entity\SubscriberGroup $subscriberGroups)
    {
        $this->subscriberGroups->removeElement($subscriberGroups);
    }

    /**
     * Get subscriberGroups
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getSubscriberGroups()
    {
        return $this->subscriberGroups;
    }

    /**
     * @param \Doctrine\Common\Collections\ArrayCollection $subscriber
     */
    public function setSubscriber(ArrayCollection $subscriber)
    {
        $this->subscriber = $subscriber;
    }

    /**
     * @param \Doctrine\Common\Collections\ArrayCollection $subscriberGroups
     */
    public function setSubscriberGroups(ArrayCollection $subscriberGroups)
    {
        $this->subscriberGroups = $subscriberGroups;
    }


}