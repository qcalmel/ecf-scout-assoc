<?php

namespace App\Controller;

use App\Entity\Camp;
use App\Form\CampType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CampController extends AbstractController
{
    /**
     * @Route("/camp", name="camp")
     */
    public function index(): Response
    {
        return $this->render('camp/index.html.twig', [
            'controller_name' => 'CampController',
        ]);
    }

    /**
     * @Route("/camp/new", name="camp_add")
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @param Camp|null $camp
     * @return Response
     */
    public function addEdit(Request $request, EntityManagerInterface $manager, Camp $camp = null){
        if (!$camp) $camp = new Camp();
        $form = $this->createForm(CampType::class,$camp);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $manager->persist($camp);
            $manager->flush();
            return $this->redirectToRoute("camp_add");
        }
        return $this->render('camp/form.html.twig',[
            'campForm'=> $form->createView(),
            'post'=>$_POST
        ]);
    }
}
