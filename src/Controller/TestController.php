<?php

namespace App\Controller;

use App\Repository\AgeRangeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TestController extends AbstractController
{
    /**
     * @Route("/test", name="test")
     */
    public function index(AgeRangeRepository $repository): Response
    {
        dump($repository->findAgeRange(10));
        dump($repository->findOneBy(['maxAge'=>8]));
        return $this->render('test/index.html.twig', [
            'controller_name' => 'TestController',
        ]);
    }
}
