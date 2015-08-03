<?php
namespace Devblock\CourseGrabBundle\Event;

use Symfony\Component\EventDispatcher\Event;

class CourseCapacityChange extends Event {
    
    private $course;

    public function __construct($course) {
        $this->course = $course;
    }
    
    public function getCourse() {
        return $this->course;
    }
}
