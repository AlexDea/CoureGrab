<?php

namespace Devblock\CourseGrabBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * notifyUser
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Devblock\CourseGrabBundle\Entity\Repository\NotifyUserRepository")
 */
class NotifyUser
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
     * @ORM\Column(name="email", type="string", length=255, nullable=true)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="phoneNumber", type="string", length=255, nullable=true)
     */
    private $phoneNumber;

    /**
     * @var string
     * @ORM\ManyToMany(targetEntity="Course")
	 * @ORM\JoinTable(name="notification_association",
	 *      joinColumns={@ORM\JoinColumn(name="notify_user_id", referencedColumnName="id")},
	 *      inverseJoinColumns={@ORM\JoinColumn(name="course_id", referencedColumnName="id")}
	 *      )
     */
    private $courses;

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
     * @return notifyUser
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
     * Set phoneNumber
     *
     * @param string $phoneNumber
     * @return notifyUser
     */
    public function setPhoneNumber($phoneNumber)
    {
        $this->phoneNumber = $phoneNumber;

        return $this;
    }

    /**
     * Get phoneNumber
     *
     * @return string 
     */
    public function getPhoneNumber()
    {
        return $this->phoneNumber;
    }

    /**
     * Set courses
     *
     * @param string $courses
     * @return notifyUser
     */
    public function setCourses($courses)
    {
        $this->courses = $courses;

        return $this;
    }

    /**
     * Get courses
     *
     * @return string 
     */
    public function getCourses()
    {
        return $this->courses;
    }
}
