<?php

namespace Devblock\CourseGrabBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Validator\Constraints as Assert;
use Devblock\CourseGrabBundle\Entity\NotifyUser;

class NotifyApiController extends Controller {

    public function postNotifyAction(Request $request) {
        $params = $this->getParamsFromRequest($request);

        $success = false;

        //validate email
        $emailConstraint = new Assert\Email();
        $emailConstraint->message = 'Email is invalid.';
        $emailConstraint->checkMX = true;

        $errors = $this->get('validator')->validate(
                $params['email'], $emailConstraint
        );
        //convert errors into understandable errors
        $errs = array();
        foreach ($errors as $error) {
            $errs[] = $error->getMessage();
        }
        $errors = $errs;

        if (count($errors) == 0) {
            $em = $this->getDoctrine()->getManager();
            $nRepo = $em->getRepository('DevblockCourseGrabBundle:NotifyUser');
            $cRepo = $em->getRepository('DevblockCourseGrabBundle:Course');

            $nUser = $nRepo->findOneByEmail($params['email']);
            $courses = $cRepo->findByCourses($params['courses']);

            if (count($courses) > 0) {
                if (!$nUser) {
                    $nUser = new NotifyUser();
                    $nUser->setEmail($params['email']);
                    $em->persist($nUser);
                }
                $nUser->setCourses($courses);
                $em->flush();

                $errors = $this->sendWelcomeEmail($params['email'], $courses);
                //email may fail.
                $success = count($errors) == 0;
            }
        }

        $response = array(
            'success' => $success,
            'errors' => $errors,
        );

        return new JsonResponse($response);
    }

    private function sendWelcomeEmail($email, $courses) {
        $errors = array();
        try {
            $message = \Swift_Message::newInstance()
                    ->setSubject('Welcome to CourseGrab')
                    ->setFrom('no-reply@CourseGrab.com')
                    ->setTo($email)
                    ->setContentType("text/html")
                    ->setBody($this->renderView(
                            'DevblockCourseGrabBundle:Email:welcome.html.twig', array('courses' => $courses)
            ));
            $this->get('mailer')->send($message);
        } catch (\Swift_TransportException $e) {
            $errors[] = 'Failed to send email!';
            $errors[] = $e->getMessage();
        }
        return $errors;
    }

    public function getParamsFromRequest(Request $request) {
        $params = array(
            'email' => $request->get('email'),
            'courses' => $request->get('courses'),
        );
        //remove any null values
        return array_filter($params);
    }

}
