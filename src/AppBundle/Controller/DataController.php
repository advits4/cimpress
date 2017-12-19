<?php
namespace AppBundle\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Service\ImportService;
use AppBundle\Entity\Data;
use Symfony\Component\HttpFoundation\Request;

class DataController extends Controller
{

    public function __construct(ImportService $importService)
    {
        $this->importService = $importService;
    }

    /**
     * @Route("/", name="list")
     */
    public function listAction(Request $request)
    {
        $filter = '';
        $em = $this->getDoctrine()->getManager();
        $queryBuilder = $em->getRepository(Data::class)->createQueryBuilder('d');
        if ($request->query->getAlnum('filter')) {
            $filter = $request->query->getAlnum('filter');
            $queryBuilder
                ->where('d.name LIKE :name')
                ->setParameter('name', '%' . $filter . '%');
        }
        $paginatior = $this->get('knp_paginator');
        $datas = $paginatior->paginate(
            $queryBuilder->getQuery(),
            $request->query->getInt('page', 1),
            $request->query->getInt('limit', 10)
        );
        
        return $this->render('data/index.html.twig', array(
            'datas' => $datas,
            'filter' => $filter
        ));
    }
}