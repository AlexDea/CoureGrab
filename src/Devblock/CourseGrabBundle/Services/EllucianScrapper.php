<?php

namespace Devblock\CourseGrabBundle\Services;

use Doctrine\ORM\EntityManager;
use Goutte\Client;
use GuzzleHttp\Client as GuzzleClient;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Output\NullOutput;
use Devblock\CourseGrabBundle\Entity\Course;

class EllucianScrapper {

    /** @var $em Doctrine\ORM\EntityManager */
    protected $em;

    /** @var $client Goutte\Client */
    protected $client;

    /** @var $school string */
    protected $school;
    
    /** @var $output OutputInterface */
    protected $output;

    //starting at 0
    //Note: 5.5 and below doesn't support arrays in constants.....so just use a static...
    public static $COURSE_TABLE_KEYS = array(
        2 => 'course_number',
        3 => 'subject',
        4 => 'subject_number',
        5 => 'section',
        6 => 'campus',
        7 => 'credits',
        8 => 'title',
        9 => 'days',
        10 => 'time',
        11 => 'capacity',
        12 => 'attending',
        18 => 'instructor',
        20 => 'location',
    );
    const COURSE_TABLE_COLUMNS = 21;

    public function __construct(EntityManager $em, $school, OutputInterface $output = null) {
        $this->em = $em;
        $this->school = $school;
        $this->output = $output;
        if ($this->output == null) { $this->output = new NullOutput(); }
        
        $this->client = new Client();
        //Accept all ssl no matter what
        $this->client->setClient(new GuzzleClient([ 'verify' => false]));
    }

    public function fetchSemesters($url) {
        $semesters = array();
        $crawler = $this->client->request('GET', $url);

        $options = $crawler->filter('#term_input_id')->children();
        foreach ($options as $option) {
            $text = strtolower(trim($option->nodeValue));
            //var_dump($text);
            //var_dump(strstr($text, '(view only)'));
            if ($text !== 'none' && !strstr($text, '(view only)')) {
                ///replace "semester " to use to fill data in courses
                $text = str_replace('semester ', '', $text);
                $id = $option->getAttribute('value');
                $semesters[$id] = $text;
            }
        }

        return $semesters;
    }

    public function fetchCourses($url, $semesters) {
        $courses = array();
        foreach ($semesters as $semesterId => $semester) {
            $params = array(
                'term_in'       => $semesterId,
                'sel_day'       => 'dummy',
                'sel_schd'      => 'dummy',
                'sel_insm'      => 'dummy',
                'sel_camp'      => 'dummy',
                'sel_levl'      => 'dummy',
                'sel_sess'      => 'dummy',
                'sel_crse'      => '',
                'sel_title'     => '',
                'sel_from_cred' => '',
                'sel_to_cred'   => '',
                'sel_subj'      => array('dummy', '%'),
                'sel_ptrm'      => array('dummy', '%'),
                'sel_loc'       => array('dummy', '%'),
                'sel_instr'     => array('dummy', '%'),
                'sel_attr'      => array('dummy', '%'),
                'begin_hh'      => '0',
                'begin_mi'      => '0',
                'begin_ap'      => 'a',
                'end_hh'        => '0',
                'end_mi'        => '0',
                'end_ap'        => 'a',
            );
        
            $crawler = new Crawler($this->getPostPage($url, $params));
            $courseTable = $crawler->filter('.datadisplaytable')->first();
            unset($crawler); //try and reduce memory use

            $tempCourses = $this->parseCourses($courseTable, $semester);
           
            $courses = array_merge($courses, $tempCourses);
            
        }

        return $courses;
    }

    public function parseCourses(Crawler $crawler, $semester) { 
        $courses = $crawler->filter('tr')->each(function(Crawler $node, $i) use($semester) {
            //var_dump($node);
            $course = null;

            $columns = $node->filter('td');
            $count = count($columns);
            if ($count == self::COURSE_TABLE_COLUMNS) {
                $course = $this->createCourseFromRow($columns, $semester);
            }
            
            return $course;
        });
       
        //remove any null values
        return array_filter($courses);
    }

    /**
     * Creates a course from a crawler table row
     * 
     * @param Crawler $columns
     * @param string $semester
     * @return Course
     */
    public function createCourseFromRow(Crawler $columns, $semester) {
        $course = new Course();

        $i = 0;
        foreach ($columns as $col) {
            $tableKeys = self::$COURSE_TABLE_KEYS;
            if (array_key_exists($i, $tableKeys)) {
                $text = trim($col->nodeValue);
                switch ($tableKeys[$i]) {
                    case 'course_number':
                        /* This makes an assumption that course number is first 
                         * TODO: find a better way to handle this...
                         */
                        $oldCourse = $this->em->getRepository('DevblockCourseGrabBundle:Course')
                            ->findBySchoolAndCRN($this->school, $text);
                        if ($oldCourse) {
                            $course = $oldCourse;
                        }
     
                        $course->setCourseNumber($text);
                        break;
                    case 'subject':
                        $course->setSubject($text);
                        break;
                    case 'subject_number':
                        $course->setSubjectNumber($text);
                        break;
                    case 'section':
                        $course->setSection($text);
                        break;
                    case 'campus':
                        $course->setCampus($text);
                        break;
                    case 'credits':
                        $course->setCredits((int) $text);
                        break;
                    case 'title':
                        $course->setTitle($text);
                        break;
                    case 'days':
                        $course->setDays($text);
                        break;
                    case 'time':
                        $format = '!h:i a';
                        $times = explode('-', $text);
                        if (count($times) == 2) {
                            $course->setStartTime(\DateTime::createFromFormat($format, $times[0]));
                            $course->setEndTime(\DateTime::createFromFormat($format, $times[1]));
                        }
                        break;
                    case 'capacity':
                        $course->setCapacity((int) $text);
                        break;
                    case 'attending':
                        $course->setAttending((int) $text);
                        break;
                    case 'instructor':
                        $course->setInstructor($text);
                        break;
                    case 'location':
                        $course->setLocation($text);
                        break;

                    default:
                }
            }
            $i++;
        }

        //get semester and year from semester
        $s = explode(' ', $semester);
        $course->setSemester($s[0]);
        $course->setYear(\DateTime::createFromFormat('!Y', $s[1]));

        $course->setSchool($this->school);

        return $course;
    }

    public function getPostPage($url, $data) {
        //http://stackoverflow.com/questions/8170306/http-build-query-with-same-name-parameters
        $query = http_build_query($data, null);
        $query = preg_replace('/%5B(?:[0-9]|[1-9][0-9]+)%5D=/', '=', $query);

        //var_dump($query);
        //open connection
        $ch = curl_init($url);

        //set the url, number of POST vars, POST data
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $query);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        //execute post
        $result = curl_exec($ch);

        //close connection        //set the url, number of POST vars, POST data
        curl_close($ch);

        return $result;
    }

}
