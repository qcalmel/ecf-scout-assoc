<?php

namespace App\Controller;

use App\Entity\Camp;
use App\Form\CampType;
use App\Repository\CampRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CampController extends AbstractController
{
    /**
     * @Route("/camp", name="camp")
     * @param CampRepository $repository
     * @return Response
     */
    public function index(CampRepository $repository): Response
    {
        $campList = $repository->findAll();
        return $this->render('camp/index.html.twig', [
            'campList' => $campList,
        ]);
    }

    /**
     * @Route("/camp/new", name="camp_add")
     * @Route("/camp/edit/{id}",
     *     name="camp_edit",
     *     requirements={"id":"\d+"})
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
            return $this->redirectToRoute("camp");
        }
        return $this->render('camp/form.html.twig',[
            'campForm'=> $form->createView(),
            'post'=>$_POST
        ]);
    }

    /**
     * @Route("/camp/delete/{id}",
     *     name="camp_delete",
     *     requirements={"id":"\d+"}
     *     )
     * @param Camp $camp
     * @param EntityManagerInterface $manager
     * @return RedirectResponse
     */
    public function delete(Camp $camp, EntityManagerInterface $manager){
        $manager->remove($camp);
        $manager->flush();

        return $this->redirectToRoute("camp");
    }
}
