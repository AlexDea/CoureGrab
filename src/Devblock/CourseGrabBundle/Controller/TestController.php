<?php

namespace Devblock\CourseGrabBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Devblock\CourseGrabBundle\Services\EllucianScrapper;
use Devblock\CourseGrabBundle\Event\CourseCapacityChange;

class TestController extends Controller
{
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        
        //$scrapper = new EllucianScrapper($em, 'Georgia State University');
        //$semesters = $scrapper->fetchSemesters('https://www.gosolar.gsu.edu/bprod/bwckschd.p_disp_dyn_sched');
        //$courses = $scrapper->fetchCourses('https://www.gosolar.gsu.edu/bprod/bwckschd.p_get_crse_unsec', $semesters);
        /*
        foreach ($courses as $course) {
            $em->persist($course);
        }
        
        $em->flush();
        */
        $dispatcher = $this->container->get('event_dispatcher');
        
        $cRepo = $em->getRepository('DevblockCourseGrabBundle:Course');
        $course = $cRepo->find(194249);
         
        
        if (($course->getCapacity() - $course->getAttending()) > 0) {
            $event = new CourseCapacityChange($course);
            $dispatcher->dispatch('course.capacity.changed', $event);
        }
        
        //var_dump($course);
        return new Response('<h1>Scrapped courses.</h1>');
    }
    
}
