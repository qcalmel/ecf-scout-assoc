<?php

namespace App\Controller;

use App\Entity\Animator;
use App\Form\AnimatorType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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

    /**
     * @Route("/animator/new", name="animator_add")
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @param Animator|null $animator
     * @return Response
     */
    public function addEdit(Request $request, EntityManagerInterface $manager, Animator $animator = null){
        if (!$animator) $animator = new Animator();
        $form = $this->createForm(AnimatorType::class,$animator);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $manager->persist($animator);
            $manager->flush();
            return $this->redirectToRoute("animator_add");
        }
        return $this->render('animator/form.html.twig',[
            'animatorForm'=> $form->createView(),
            'post'=>$_POST
        ]);
    }
}
