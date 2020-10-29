<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AnimatorController extends AbstractController
{
    /**
     * @Route("/animator", name="animator")
     */
    public function index(): Response
    {
        return $this->render('animator/index.html.twig', [
            'controller_name' => 'AnimatorController',
        ]);
    }
}
