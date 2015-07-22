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
            'school'    => $request->get('school'),
            'semester'  => $request->get('semester'),
            'year'      => $request->get('year'),
            'location'  => $request->get('location'),
            'instructor' => $request->get('instructor'),
            'days'      => $request->get('days'),
            'subject'   => $request->get('subject'),
            'subjectNumber' => $request->get('subjectNumber'),
            'courseNumber'  => $request->get('courseNumber'),
            'section'   => $request->get('section'),
            'credits'   => $request->get('credits'),
            'title'     => $request->get('title'),
            'campus'    => $request->get('campus'),
            'startTime' => $request->get('startTime'),
            'endTime'   => $request->get('endTime'),
        );
        $params = array_filter($params); //remove any null values
        
        $limit = $request->get('limit', 5);
        $offset = $request->get('offset', 0);
        
        $courses = $em->getRepository('DevblockCourseGrabBundle:Course')
                ->findBy($params, null, $limit, $offset);
        
        return new JsonResponse($courses);
    }
    
    public function postFiltersAction(Request $request) {
        $filters = array(
            'school'    => $request->get('school'),
            'semester'  => $request->get('semester'),
            'year'      => $request->get('year'),
            'location'  => $request->get('location'),
            'instructor' => $request->get('instructor'),
            'days'      => $request->get('days'),
            'subject'   => $request->get('subject'),
            'subjectNumber' => $request->get('subjectNumber'),
            'courseNumber'  => $request->get('courseNumber'),
            'section'   => $request->get('section'),
            'credits'   => $request->get('credits'),
            'campus'    => $request->get('campus'),
            'startTime' => $request->get('startTime'),
            'endTime'   => $request->get('endTime'),
        );
        $filters = array_filter($filters); //remove any null values
        
        $em = $this->getDoctrine()->getManager();

        $repo = $em->getRepository('DevblockCourseGrabBundle:Course');
        $selections = array(
            'schools'   => $repo->findSchoolsByFilters($filters),
            'subjects'  => $repo->findSubjectsByFilters($filters),
            'semesters' => $repo->findSemestersByFilters($filters),
            'years'     => $repo->findYearsByFilters($filters),
            'locations' => $repo->findLocationsByFilters($filters),
            'instructors'    => $repo->findInstructorsByFilters($filters),
            'subjectNumbers' => $repo->findSubjectNumbersByFilters($filters),
            'courseNumbers'  => $repo->findCourseNumbersByFilters($filters),
            'sections'   => $repo->findSectionsByFilters($filters),
            'credits'    => $repo->findCreditsByFilters($filters),
            'campuses'   => $repo->findCampusesByFilters($filters),
            'startTimes' => $repo->findStartTimesByFilters($filters),
            'endTimes' => $repo->findEndTimesByFilters($filters),
        );
        
        return new JsonResponse($selections);
    }
    
}
