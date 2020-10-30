<?php

namespace App\Controller;

use App\Entity\Child;
use App\Form\ChildType;
use App\Repository\ChildRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ChildController extends AbstractController
{

    /**
     * @Route("/child", name="child")
     * @param ChildRepository $repository
     * @return Response
     */
    public function index(ChildRepository $repository): Response
    {
        $childList = $repository->findAll();
        return $this->render('child/index.html.twig', [
            'childList' => $childList,
        ]);
    }

    /**
     * @Route("/child/new", name="child_add")
     * @Route("/child/edit/{id}",
     *     name="child_edit",
     *     requirements={"id":"\d+"})
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

    /**
     * @Route("/child/delete/{id}",
     *     name="child_delete",
     *     requirements={"id":"\d+"}
     *     )
     * @param Child $child
     * @param EntityManagerInterface $manager
     * @return RedirectResponse
     */
    public function delete(Child $child, EntityManagerInterface $manager){
        $manager->remove($child);
        $manager->flush();

        return $this->redirectToRoute("child");
    }
}
