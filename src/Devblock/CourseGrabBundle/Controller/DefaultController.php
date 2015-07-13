<?php

namespace Devblock\CourseGrabBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        
        $courses = $em->getRepository('DevblockCourseGrabBundle:Course')->findAll();
        return $this->render('DevblockCourseGrabBundle:Default:index.html.twig', array(
            'courses' => $courses,
        ));
    }
}
