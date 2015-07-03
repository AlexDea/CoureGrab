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
        
        $scrapper = new EllucianScrapper($em);
        $semesters = $scrapper->fetchSemesters('https://www.gosolar.gsu.edu/bprod/bwckschd.p_disp_dyn_sched');
        $html = $scrapper->fetchCourses('https://www.gosolar.gsu.edu/bprod/bwckschd.p_get_crse_unsec', $semesters);
        
        var_dump($html);
        return new Response();
    }
}
