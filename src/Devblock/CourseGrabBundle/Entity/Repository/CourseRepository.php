<?php

namespace Devblock\CourseGrabBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;

/**
 * CourseRepository
 *
 */
class CourseRepository extends EntityRepository {

    
    /**
     * Counts courses
     * 
     * @param array $filters
     * @return int
     */
    public function count($filters = array()) {
        $query = $this->createQueryBuilder('c')
                ->select('COUNT(c.id)');
        $query = $this->applyFilters($query, $filters);
        
        return $query->getQuery()->getSingleScalarResult();
    }
    
    /**
     * Takes an array of courses identified by "school" and "courseNumber"
     * 
     * @param array $courses
     * @return Course[]
     */
    public function findByCourses($courses = array()) {
        $ids = array();
        $count = count($courses);
        for ($i=0; $i < $count; $i++) {
            if (isset($courses[$i]['id'])) {
                $ids[] = $courses[$i]['id'];
            }
        }
        $query = $this->createQueryBuilder('c')
                ->where('c.id IN (:ids)')
                ->setParameter('ids', $ids);
        
        //var_dump($query->getQuery()->getSQL());
        return $query->getQuery()->getResult();        
    }
    
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

    public function applyFilters(QueryBuilder $builder, $filters) {
        foreach ($filters as $key => $value) {
            $builder->andWhere('c.' . $key . ' =  :' . $key)
                    ->setParameter($key, $value);
        }
        return $builder;
    }

    public function findByFilters($column, $filters) {
        $query = $this->createQueryBuilder('c')
                ->select('DISTINCT c.' . $column)
                ->orderBy('c.' . $column);
        $query = $this->applyFilters($query, $filters);

        $results = $query->getQuery()->getResult();

        return $results;
    }

    public function presentDataInSelectFormat($results, $column) {
        $newResults = array();
        foreach ($results as $result) {
            $a = array(
                'name' => $result[$column],
                'value' => $result[$column],
            );
            array_push($newResults, $a);
        }
        return $newResults;
    }

    public function findSchoolsByFilters($filters) {
        $column = 'school';
        $results = $this->presentDataInSelectFormat(
                $this->findByFilters($column, $filters), $column);
        return $results;
    }

    public function findSubjectsByFilters($filters) {
        $column = 'subject';
        $results = $this->presentDataInSelectFormat(
                $this->findByFilters($column, $filters), $column);
        return $results;
    }

    public function findSemestersByFilters($filters) {
        $column = 'semester';
        $results = $this->presentDataInSelectFormat(
                $this->findByFilters($column, $filters), $column);
        return $results;
    }

    public function findYearsByFilters($filters) {
        $column = 'year';
        $years = $this->findByFilters($column, $filters);
        $newYears = array();
        foreach ($years as $year) {
            $arr = array('year' => $year['year']->format(\DateTime::ISO8601));
            array_push($newYears, $arr);
        }
        return $this->presentDataInSelectFormat($newYears, $column);
    }

    public function findLocationsByFilters($filters) {
        $column = 'location';
        $results = $this->presentDataInSelectFormat(
                $this->findByFilters($column, $filters), $column);
        return $results;
    }

    public function findInstructorsByFilters($filters) {
        $column = 'instructor';
        $results = $this->presentDataInSelectFormat(
                $this->findByFilters($column, $filters), $column);
        return $results;
    }

    public function findSubjectNumbersByFilters($filters) {
        $column = 'subjectNumber';
        $results = $this->presentDataInSelectFormat(
                $this->findByFilters($column, $filters), $column);
        return $results;
    }

    public function findCourseNumbersByFilters($filters) {
        $column = 'courseNumber';
        $results = $this->presentDataInSelectFormat(
                $this->findByFilters($column, $filters), $column);
        return $results;
    }

    public function findSectionsByFilters($filters) {
        $column = 'section';
        $results = $this->presentDataInSelectFormat(
                $this->findByFilters($column, $filters), $column);
        return $results;
    }

    public function findCreditsByFilters($filters) {
        $column = 'credits';
        $results = $this->presentDataInSelectFormat(
                $this->findByFilters($column, $filters), $column);
        return $results;
    }

    public function findCampusesByFilters($filters) {
        $column = 'campus';
        $results = $this->presentDataInSelectFormat(
                $this->findByFilters($column, $filters), $column);
        return $results;
    }

    public function findStartTimesByFilters($filters) {
        $column = 'startTime';
        $results = $this->presentDataInSelectFormat(
                $this->findByFilters($column, $filters), $column);
        return $results;
    }

    public function findEndTimesByFilters($filters) {
        $column = 'endTime';
        $results = $this->presentDataInSelectFormat(
                $this->findByFilters($column, $filters), $column);
        return $results;
    }

}
