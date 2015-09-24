<?php

namespace Devblock\CourseGrabBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class CourseApiController extends Controller
{
    public function postCoursesAction(Request $request) {
        $params = $this->getParamsFromRequest($request);
        $limit = $request->request->get('limit', 20);
        $page = $request->request->get('page', 1);
        
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository('DevblockCourseGrabBundle:Course');
        
        //$total = $repo->count($params);
        $offset = ($page - 1) * $limit;
        
        $courses = $repo->findBy($params, null, $limit, $offset);
        //var_dump(json_encode($courses));
        return new JsonResponse($courses);
    }
    
    public function postFiltersAction(Request $request) {
        $filters = $this->getParamsFromRequest($request);
        
        $em = $this->getDoctrine()->getManager();

        $repo = $em->getRepository('DevblockCourseGrabBundle:Course');
        $selections = array(
            'schools'        => $repo->findSchoolsByFilters($filters),
            'subjects'       => $repo->findSubjectsByFilters($filters),
            'semesters'      => $repo->findSemestersByFilters($filters),
            'years'          => $repo->findYearsByFilters($filters),
            'locations'      => $repo->findLocationsByFilters($filters),
            'instructors'    => $repo->findInstructorsByFilters($filters),
            'subjectNumbers' => $repo->findSubjectNumbersByFilters($filters),
            'courseNumbers'  => $repo->findCourseNumbersByFilters($filters),
            'sections'       => $repo->findSectionsByFilters($filters),
            'credits'        => $repo->findCreditsByFilters($filters),
            'campuses'       => $repo->findCampusesByFilters($filters),
            'startTimes'     => $repo->findStartTimesByFilters($filters),
            'endTimes'       => $repo->findEndTimesByFilters($filters),
        );
        
        return new JsonResponse($selections);
    }
    
    public function postCountPagesAction(Request $request) {
        $params = $this->getParamsFromRequest($request);
        $limit = $request->request->get('limit', 21);
        
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository('DevblockCourseGrabBundle:Course');
        
        $total = $repo->count($params);
        
        $pageData = array(
            'total' => $total,
            'pages' => ceil($total / $limit),
        );
        
        return new JsonResponse($pageData);
    }
    
    public function getParamsFromRequest(Request $request) {
         $params = array(
            'school'        => $request->request->get('school'),
            'semester'      => $request->request->get('semester'),
            'year'          => $request->request->get('year'),
            'location'      => $request->request->get('location'),
            'instructor'    => $request->request->get('instructor'),
            'days'          => $request->request->get('days'),
            'subject'       => $request->request->get('subject'),
            'subjectNumber' => $request->request->get('subjectNumber'),
            'courseNumber'  => $request->request->get('courseNumber'),
            'section'       => $request->request->get('section'),
            'credits'       => $request->request->get('credits'),
            'title'         => $request->request->get('title'),
            'campus'        => $request->request->get('campus'),
            'startTime'     => $request->request->get('startTime'),
            'endTime'       => $request->request->get('endTime'),
        );
        //remove any null values
        return array_filter($params);
    }
    
}
