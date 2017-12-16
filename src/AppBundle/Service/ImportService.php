<?php
namespace AppBundle\Service;

use Symfony\Component\DependencyInjection\ContainerInterface;
// use Symfony\Component\HttpFoundation\ParameterBag;
// use Doctrine\DBAL\Connection;
use AppBundle\Entity\Data;

class ImportService
{

	public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        // $this->conn = $this->container->get('doctrine.dbal.default_connection');
    }

    public function import() {
        $repositories = $this->fetchRepositories();
    	$em = $this->container->get('doctrine')->getManager();
    	$batchSize = 15;
        for ($i=0; $i<count($repositories['repositories']); $i++) {
            $symfo = new Data();
	    	$symfo->setName($repositories['repositories'][$i]['name']);
	    	$symfo->setOwner($repositories['repositories'][$i]['owner']);
	        $em->persist($symfo);
	        
            if (($i % $batchSize) === 0) {
		        $em->flush();
		        $em->clear(); 
		    }
        }
        $em->flush();
        $em->clear();
    	return true;
    }

    public function fetchRepositories() {
        $client = new \Github\Client();
        $repositories = $client->api('repo')->find('symfony');
        return $repositories;
    }
}