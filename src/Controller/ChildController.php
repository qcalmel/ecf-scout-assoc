<?php

namespace App\Controller;

use App\Entity\Child;
use App\Form\ChildType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ChildController extends AbstractController
{
    /**
     * @Route("/child/new", name="child_add")
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @param Child|null $child
     * @return Response
     */
    public function addEdit(Request $request, EntityManagerInterface $manager, Child $child = null){
        if (!$child) $child = new Child();
        $form = $this->createForm(ChildType::class,$child);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $manager->persist($child);
            $manager->flush();
            return $this->redirectToRoute("child_add");
        }
        return $this->render('child/form.html.twig',[
            'childForm'=> $form->createView(),
            'post'=>$_POST
        ]);
    }
}
