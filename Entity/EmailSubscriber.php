<?php

namespace NewsletterBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * EmailSubscriber
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="NewsletterBundle\Entity\EmailSubscriberRepository")
 */
class EmailSubscriber
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
     * @ORM\Column(name="email", type="string", length=100)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="first_ame", type="string", length=100)
     */
    private $firstName;

    /**
     * @var string
     *
     * @ORM\Column(name="last_name", type="string", length=100)
     */
    private $lastName;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     */
    private $description;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     * @ORM\ManyToMany(targetEntity="NewsletterBundle\Entity\SubscriberGroup", mappedBy="subscriber",cascade={"persist", "remove"})
     *
     * @ORM\JoinTable(name="subscriber_group_subscriber")
     */
    private $groups;

    /**
     * simple identifier if an subscriber is activated (1) or or not
     * @var int
     * @ORM\Column(name="active", type="integer")
     */
    private $active = 0;

    /**
     * to have the endpoint to the mapped subscribers in the newsletter
     * @ORM\ManyToMany(targetEntity="NewsletterBundle\Entity\Newsletter",mappedBy="subscriber")
     * @ORM\JoinTable(name="newsletter_subscriber")
     *
     * @var ArrayCollection
     */
    private $newsletter;

    public function __construct()
    {
        $this->groups = new ArrayCollection();
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
     * Set email
     *
     * @param string $email
     * @return EmailSubscriber
     */
    public function setEmail($email)
    {
        $this->email = $email;
    
        return $this;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set firstName
     *
     * @param string $firstName
     * @return EmailSubscriber
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
    
        return $this;
    }

    /**
     * Get firstName
     *
     * @return string 
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Set lastName
     *
     * @param string $lastName
     * @return EmailSubscriber
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
    
        return $this;
    }

    /**
     * Get lastName
     *
     * @return string 
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return EmailSubscriber
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
     * Get groups
     *
     * @return array 
     */
    public function getGroups()
    {
        return $this->groups;
    }

    /**
     * Set active
     *
     * @param integer $active
     * @return EmailSubscriber
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
     * Add groups
     *
     * @param \NewsletterBundle\Entity\SubscriberGroup $groups
     * @return EmailSubscriber
     */
    public function addGroup(\NewsletterBundle\Entity\SubscriberGroup $groups)
    {
        $this->groups[] = $groups;
    
        return $this;
    }

    /**
     * Remove groups
     *
     * @param \NewsletterBundle\Entity\SubscriberGroup $groups
     */
    public function removeGroup(\NewsletterBundle\Entity\SubscriberGroup $groups)
    {
        $this->groups->removeElement($groups);
    }

    /**
     * Add newsletter
     *
     * @param \NewsletterBundle\Entity\Newsletter $newsletter
     * @return EmailSubscriber
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