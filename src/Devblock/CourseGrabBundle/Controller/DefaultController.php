<?php

namespace Devblock\CourseGrabBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('DevblockCourseGrabBundle:Default:index.html.twig');
    }
}
