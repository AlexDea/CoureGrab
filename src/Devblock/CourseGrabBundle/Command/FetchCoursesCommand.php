<?php
namespace Devblock\CourseGrabBundle\Command;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Devblock\CourseGrabBundle\Services\EllucianScrapper;

class FetchCoursesCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('devblock:courseGrab:fetchCourses')
            ->setDescription('Fetches the courses from schools\' course repos')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('Fetching courses...');
        $output->writeln('Before memory: '. memory_get_peak_usage());
        $em = $this->getContainer()->get('doctrine')->getManager();
        $scrapper = new EllucianScrapper($em, 'Georgia State University', $this->getApplication()->getKernel()->getContainer()->get('event_dispatcher'), $output);
        $semesters = $scrapper->fetchSemesters('https://www.gosolar.gsu.edu/bprod/bwckschd.p_disp_dyn_sched');
        $courses = $scrapper->fetchCourses('https://www.gosolar.gsu.edu/bprod/bwckschd.p_get_crse_unsec', $semesters);
        $output->writeln('After scrapping memory: '. memory_get_peak_usage());
        
        $count = count($courses);
        for ($i=0; $i < $count; $i++) { 
            $em->persist($courses[$i]);
            if (fmod($i, 20) == 0 && $i != 0) {
                $em->flush();
               // $em->clear();
            }
        }
        $em->flush(); //flush the final persisted courses
        
        $output->writeln('Final memory: '. memory_get_peak_usage());
        
        $output->writeln('Fetched and persisted '. number_format(count($courses)) .' courses');
    }
}