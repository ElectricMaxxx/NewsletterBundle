<?php

namespace NewsletterBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
/**
 * SubscriberGroup
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
     * @ORM\ManyToMany(targetEntity="NewsletterBundle\Entity\EmailSubscriber", mappedBy="group")
     * @ORM\JoinTable(name="subscriber_group_subscriber")
     */
    private $subscriber;


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
     * Set subscriber
     *
     * @param array $subscriber
     * @return SubscriberGroup
     */
    public function setSubscriber($subscriber)
    {
        $this->subscriber = $subscriber;
    
        return $this;
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
}
