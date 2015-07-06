<?php

namespace Devblock\CourseGrabBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Course
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Devblock\CourseGrabBundle\Entity\Repository\CourseRepository")
 */
class Course
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
     * @ORM\Column(name="semester", type="string", length=10)
     */
    private $semester;

    /**
     * @var integer
     *
     * @ORM\Column(name="year", type="integer")
     */
    private $year;

    /**
     * @var string
     *
     * @ORM\Column(name="location", type="string", length=255)
     */
    private $location;

    /**
     * @var string
     *
     * @ORM\Column(name="instructor", type="string", length=255)
     */
    private $instructor;

    /**
     * @var string
     *
     * @ORM\Column(name="days", type="string", length=7)
     */
    private $days;
    
    /**
     * @var string
     *
     * @ORM\Column(name="subject", type="string", length=4)
     */
    private $subject;
    
    /**
     * @var int
     *
     * @ORM\Column(name="subjectNumber", type="smallint")
     */
    private $subjectNumber;

    /**
     * @var int
     *
     * @ORM\Column(name="courseNumber", type="smallint")
     */
    private $courseNumber;
    
    /**
     * @var string
     * 
     * @ORM\Column(name="section", type="smallint")
     */
    private $section;

    /**
     * @var integer
     *
     * @ORM\Column(name="credits", type="smallint")
     */
    private $credits;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=100)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="campus", type="string", length=20)
     */
    private $campus;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="startTime", type="datetime")
     */
    private $startTime;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="endTime", type="datetime")
     */
    private $endTime;

    /**
     * @var integer
     *
     * @ORM\Column(name="capacity", type="smallint")
     */
    private $capacity;

    /**
     * @var integer
     *
     * @ORM\Column(name="attending", type="smallint")
     */
    private $attending;

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
     * Set semester
     *
     * @param string $semester
     * @return Course
     */
    public function setSemester($semester)
    {
        $this->semester = $semester;

        return $this;
    }

    /**
     * Get semester
     *
     * @return string 
     */
    public function getSemester()
    {
        return $this->semester;
    }

    /**
     * Set year
     *
     * @param integer $year
     * @return Course
     */
    public function setYear($year)
    {
        $this->year = $year;

        return $this;
    }

    /**
     * Get year
     *
     * @return integer 
     */
    public function getYear()
    {
        return $this->year;
    }

    /**
     * Set location
     *
     * @param string $location
     * @return Course
     */
    public function setLocation($location)
    {
        $this->location = $location;

        return $this;
    }

    /**
     * Get location
     *
     * @return string 
     */
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * Set instructor
     *
     * @param string $instructor
     * @return Course
     */
    public function setInstructor($instructor)
    {
        $this->instructor = $instructor;

        return $this;
    }

    /**
     * Get instructor
     *
     * @return string 
     */
    public function getInstructor()
    {
        return $this->instructor;
    }

    /**
     * Set days
     *
     * @param string $days
     * @return Course
     */
    public function setDays($days)
    {
        $this->days = $days;

        return $this;
    }

    /**
     * Get days
     *
     * @return string 
     */
    public function getDays()
    {
        return $this->days;
    }
    
    /**
     * Set subject
     *
     * @param string $subject
     * @return Course
     */
    public function setSubject($subject)
    {
        $this->subject = $subject;

        return $this;
    }

    /**
     * Get subject
     *
     * @return string 
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * Get subject number
     * 
     * @return int
     */
    public function getSubjectNumber() {
        return $this->subjectNumber;
    }

    /**
     * Sets subject number
     * 
     * @param int $subjectNumber
     * @return Course
     */
    public function setSubjectNumber($subjectNumber) {
        $this->subjectNumber = $subjectNumber;
        
        return $this;
    }

        
    /**
     * Set courseNumber
     *
     * @param int $courseNumber
     * @return Course
     */
    public function setCourseNumber($courseNumber)
    {
        $this->courseNumber = $courseNumber;

        return $this;
    }

    /**
     * Get courseNumber
     *
     * @return int
     */
    public function getCourseNumber()
    {
        return $this->courseNumber;
    }

    /**
     * Get section number
     * 
     * @return int
     */
    public function getSection() {
        return $this->section;
    }

    /**
     * Sets section number
     * 
     * @param int $section
     * @return Course
     */
    public function setSection($section) {
        $this->section = $section;
        
        return $this;
    }

    /**
     * Set credits
     *
     * @param integer $credits
     * @return Course
     */
    public function setCredits($credits)
    {
        $this->credits = $credits;

        return $this;
    }

    /**
     * Get credits
     *
     * @return integer 
     */
    public function getCredits()
    {
        return $this->credits;
    }

    /**
     * Set title
     *
     * @param string $title
     * @return Course
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
     * Set campus
     *
     * @param string $campus
     * @return Course
     */
    public function setCampus($campus)
    {
        $this->campus = $campus;

        return $this;
    }

    /**
     * Get campus
     *
     * @return string 
     */
    public function getCampus()
    {
        return $this->campus;
    }

    /**
     * Set startTime
     *
     * @param \DateTime $startTime
     * @return Course
     */
    public function setStartTime($startTime)
    {
        $this->startTime = $startTime;

        return $this;
    }

    /**
     * Get startTime
     *
     * @return \DateTime 
     */
    public function getStartTime()
    {
        return $this->startTime;
    }

    /**
     * Set endTime
     *
     * @param \DateTime $endTime
     * @return Course
     */
    public function setEndTime($endTime)
    {
        $this->endTime = $endTime;

        return $this;
    }

    /**
     * Get endTime
     *
     * @return \DateTime 
     */
    public function getEndTime()
    {
        return $this->endTime;
    }

    /**
     * Set capacity
     *
     * @param integer $capacity
     * @return Course
     */
    public function setCapacity($capacity)
    {
        $this->capacity = $capacity;

        return $this;
    }

    /**
     * Get capacity
     *
     * @return integer 
     */
    public function getCapacity()
    {
        return $this->capacity;
    }

    /**
     * Set attending
     *
     * @param integer $attending
     * @return Course
     */
    public function setAttending($attending)
    {
        $this->attending = $attending;

        return $this;
    }

    /**
     * Get attending
     *
     * @return integer 
     */
    public function getAttending()
    {
        return $this->attending;
    }

}
