<?php

namespace Devblock\CourseGrabBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * notifyUserRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class NotificationAssociationRepository extends EntityRepository
{
    /*public function findByCourse($course) {
        $query = $this->createQueryBuilder('n')
                ->where('n.courseId = :courseId')
                ->setParameter('courseId', $course->getId());
        
        return $query->getQuery()->getResult();
    }*/
}
