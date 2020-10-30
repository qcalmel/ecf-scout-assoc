<?php

namespace App\Controller;

use App\Entity\Animator;
use App\Form\AnimatorType;
use App\Repository\AnimatorRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AnimatorController extends AbstractController
{
    /**
     * @Route("/animator", name="animator")
     * @param AnimatorRepository $repository
     * @return Response
     */
    public function index(AnimatorRepository $repository): Response
    {
        $animatorList = $repository->findAll();
        dump($animatorList);
        return $this->render('animator/index.html.twig', [
            'animatorList' => $animatorList,
        ]);
    }

    /**
     * @Route("/animator/new", name="animator_add")
     * @Route("/animator/edit/{id}",
     *     name="animator_edit",
     *     requirements={"id":"\d+"})
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

    /**
     * @Route("/animator/delete/{id}",
     *     name="animator_delete",
     *     requirements={"id":"\d+"}
     *     )
     * @param Animator $animator
     * @param EntityManagerInterface $manager
     * @return RedirectResponse
     */
    public function delete(Animator $animator, EntityManagerInterface $manager){
        $manager->remove($animator);
        $manager->flush();

        return $this->redirectToRoute("animator");
    }
}
