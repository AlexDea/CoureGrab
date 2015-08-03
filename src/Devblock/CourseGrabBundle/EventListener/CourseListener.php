<?php

namespace Devblock\CourseGrabBundle\EventListener;

use Doctrine\ORM\EntityManager;
use Devblock\CourseGrabBundle\Event\CourseCapacityChange;

class CourseListener {
    /** @var $em Doctrine\ORM\EntityManager */
    protected $em;
    
    /** @var $mailer SwiftMailer */
    protected $mailer;
    
    protected $templating;
    
    public function __construct(EntityManager $em, $mailer, $templating) {
        $this->em = $em;
        $this->mailer = $mailer;
        $this->templating = $templating;
    }
    
    public function onCapacityChanged(CourseCapacityChange $event) {
        $repo = $this->em->getRepository('DevblockCourseGrabBundle:NotificationAssociation');
        
        $nAssocs= $repo->findByCourse($event->getCourse());
        
        foreach ($nAssocs as $nAssoc) {
            if (!$nAssoc->getNotified()) {
                $this->sendNotificationEmail($nAssoc->getNotifyUser(), $event->getCourse());
                $nAssoc->setNotified(true);
            }
        }
        $this->em->flush();
        
    }

    
    private function sendNotificationEmail($notifyUser, $course) {
        try {
            $message = \Swift_Message::newInstance()
                    ->setSubject('Course Notification from CourseGrab')
                    ->setFrom('no-reply@CourseGrab.com')
                    ->setTo($notifyUser->getEmail())
                    ->setContentType("text/html")
                    ->setBody($this->templating->render(
                            'DevblockCourseGrabBundle:Email:notification.html.twig', array('courses' => array($course))
            ));
            $this->mailer->send($message);
        } catch (\Swift_TransportException $e) {
            return $e->getMessage();
        }
        
    }

    
}