<?php

namespace Devblock\CourseGrabBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Devblock\CourseGrabBundle\Services\EllucianScrapper;

class TestController extends Controller
{
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        
        $scrapper = new EllucianScrapper($em, 'Georgia State University');
        $semesters = $scrapper->fetchSemesters('https://www.gosolar.gsu.edu/bprod/bwckschd.p_disp_dyn_sched');
        $courses = $scrapper->fetchCourses('https://www.gosolar.gsu.edu/bprod/bwckschd.p_get_crse_unsec', $semesters);
        
        foreach ($courses as $course) {
            $em->persist($course);
        }
        
        $em->flush();
        
        return new Response('<h1>Scrapped '. count($courses) .' courses.</h1>');
    }
}
