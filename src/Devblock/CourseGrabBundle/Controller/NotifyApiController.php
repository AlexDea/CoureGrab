<?php

namespace Devblock\CourseGrabBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class NotifyApiController extends Controller
{
    public function postNotifyAction(Request $request) {
        $params = $this->getParamsFromRequest($request);
        $limit = (int)$request->request->get('limit', 20);
        $page = (int)$request->get('page', 1);
        
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository('DevblockCourseGrabBundle:Course');
        
        //$total = $repo->count($params);
        $offset = ($page - 1) * $limit;
        
        $courses = $repo->findBy($params, null, $limit, $offset);
        //var_dump(json_encode($courses));
        return new JsonResponse($courses);
    }
    
    public function getParamsFromRequest(Request $request) {
         $params = array(
            'email'     => $request->request->get('email'),
            'courses'   => $request->request->get('courses'),
        );
        //remove any null values
        return array_filter($params);
    }
    
}
