<?php
namespace Devblock\CourseGrabBundle\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class FetchCoursesCommand extends Command
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
    }
}