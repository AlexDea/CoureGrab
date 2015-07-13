<?php

namespace Devblock\CourseGrabBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class ApiController extends Controller
{
    public function postCoursesAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        
        $params = array(
            'school' => $request->get('school'),
            'semester' => $request->get('semester'),
            'year' => $request->get('year'),
            'location' => $request->get('location'),
            'instructor' => $request->get('instructor'),
            'days' => $request->get('days'),
            'subject' => $request->get('subject'),
            'subjectNumber' => $request->get('subjectNumber'),
            'courseNumber' => $request->get('courseNumber'),
            'section' => $request->get('section'),
            'credits' => $request->get('credits'),
            'title' => $request->get('title'),
            'campus' => $request->get('campus'),
            'startTime' => $request->get('startTime'),
            'endTime' => $request->get('endTime'),
        );
        $params = array_filter($params); //remove any null values
        
        $limit = $request->get('limit', 5);
        $offset = $request->get('offset', 0);
        
        $courses = $em->getRepository('DevblockCourseGrabBundle:Course')
                ->findBy($params, null, $limit, $offset);
        
        return new JsonResponse($courses);
    }
}
