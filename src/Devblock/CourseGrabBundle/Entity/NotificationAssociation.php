<?php

namespace Devblock\CourseGrabBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * NotificationAssociation
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Devblock\CourseGrabBundle\Entity\Repository\NotificationAssociationRepository")
 */
class NotificationAssociation
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
     * @var Course
     *
     * @ORM\ManyToOne(targetEntity="Course", inversedBy="notificationAssociation")
     */
    private $course;
    
     /**
     * @var NotifyUser
     *
     * @ORM\ManyToOne(targetEntity="NotifyUser", inversedBy="notificationAssociation")
     */
    private $notifyUser;
    
    /**
     * @var bool
     * 
     * @ORM\Column(name="notified", type="boolean")
     */
    private $notified;

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    public function __construct() {
        $this->setNotified(false);
    }
    
    /**
     * Set notified
     *
     * @param boolean $notified
     * @return NotificationAssociation
     */
    public function setNotified($notified)
    {
        $this->notified = $notified;

        return $this;
    }

    /**
     * Get notified
     *
     * @return boolean 
     */
    public function getNotified()
    {
        return $this->notified;
    }

    /**
     * Set course
     *
     * @param \Devblock\CourseGrabBundle\Entity\Course $course
     * @return NotificationAssociation
     */
    public function setCourse($course = null)
    {
        $this->course = $course;

        return $this;
    }

    /**
     * Get course
     *
     * @return \Devblock\CourseGrabBundle\Entity\Course 
     */
    public function getCourse()
    {
        return $this->course;
    }

    /**
     * Set notifyUser
     *
     * @param \Devblock\CourseGrabBundle\Entity\NotifyUser $notifyUser
     * @return NotificationAssociation
     */
    public function setNotifyUser($notifyUser = null)
    {
        $this->notifyUser = $notifyUser;

        return $this;
    }

    /**
     * Get notifyUser
     *
     * @return \Devblock\CourseGrabBundle\Entity\NotifyUser 
     */
    public function getNotifyUser()
    {
        return $this->notifyUser;
    }
}
