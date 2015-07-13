<?php

namespace Devblock\CourseGrabBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * CourseRepository
 *
 */
class CourseRepository extends EntityRepository {
    
    /**
     * Finds courses from school and crn
     * 
     * @param string $school
     * @param string $crn
     */
    public function findBySchoolAndCRN($school, $crn) {
        $query = $this->createQueryBuilder('c')
                ->where('c.school = :school')
                ->setMaxResults(1)
                ->andWhere('c.courseNumber = :crn')
                ->setParameter('school', $school)
                ->setParameter('crn', $crn);

        return $query->getQuery()->getOneOrNullResult();
    }
   
}
