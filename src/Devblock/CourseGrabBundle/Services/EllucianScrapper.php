<?php

namespace Devblock\CourseGrabBundle\Services;

use Doctrine\ORM\EntityManager;
use Goutte\Client;
use GuzzleHttp\Client as GuzzleClient;

class EllucianScrapper {
    /*
     * @var Doctrine\ORM\EntityManager
     */

    protected $em;

    /*
     * @var Goutte\Client
     */
    protected $client;

    public function __construct(EntityManager $em) {
        $this->em = $em;
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
                $id = $option->getAttribute('value');
                array_push($semesters, $id);
            }
        }
        
        return $semesters;
    }

    public function fetchCourses($url, $semesters) {
        var_dump($semesters);
        foreach ($semesters as $semester) {
            $params = array('term_in' => $semester,
                'sel_subj' => 'dummy',
                'sel_day' => 'dummy',
                'sel_schd' => 'dummy',
                'sel_insm' => 'dummy',
                'sel_camp' => 'dummy',
                'sel_loc' => 'dummy',
                'sel_levl' => 'dummy',
                'sel_sess' => 'dummy',
                'sel_instr' => 'dummy',
                'sel_ptrm' => 'dummy',
                'sel_attr' => 'dummy',
                'sel_subj' => '%',
                'sel_crse' => '',
                'sel_title' => '',
                'sel_from_cred' => '',
                'sel_to_cred' => '',
                'sel_ptrm' => '%',
                'sel_loc' => '%',
                'sel_instr' => '%',
                'sel_attr' => '%',
                'begin_hh' => '0',
                'begin_mi' => '0',
                'begin_ap' => 'a',
                'end_hh' => '0',
                'end_mi' => '0',
                'end_ap' => 'a',
            );

            $this->client->getClient()->get($url, ['verify' => false]);
            // $client->getClient()->setDefaultOption('config/curl/'.CURLOPT_SSL_VERIFYHOST, FALSE);
            // $client->getClient()->setDefaultOption('config/curl/'.CURLOPT_SSL_VERIFYPEER, FALSE);

            $this->client->addPostFields($params);
            $crawler = $this->client->request('POST', $url);
            $html .= $crawler->html();
        }
        
        return $html;
    }

}
