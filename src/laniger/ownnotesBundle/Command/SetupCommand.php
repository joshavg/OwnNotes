<?php

namespace laniger\ownnotesBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;
use laniger\ownnotesBundle\Entity\User;

class SetupCommand extends ContainerAwareCommand
{
    
    protected function configure()
    {
        $this->setName('ownnotes:setup')
            ->setDescription('initial setup for the ownnotes bundle');
    }
    
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $qh = $this->getHelper('question');
        
        $question = new Question('Initial Admin name: ', 'admin');
        $name = $qh->ask($input, $output, $question);
        
        $question = new Question('Initial Admin password: ', 'admin');
        $question->setHidden(true);
        $pw = $qh->ask($input, $output, $question);
        
        $user = new User();
        $user->setNick($name);
        
        $factory = $this->getContainer()->get('security.encoder_factory');
        $encoded = $factory->getEncoder($user)->encodePassword($pw, null);
        $user->setPassword($encoded);
        
        $em = $this->getContainer()->get('doctrine')->getManager();
        $em->persist($user);
        $em->flush();
        
        $output->writeln('User ' . $name . ' persisted');
        $output->writeln('Please delete this file after successful setup (' . __FILE__ . ')');
    }
    
}