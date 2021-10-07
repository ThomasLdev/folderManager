<?php

namespace App\Controller;

use App\Entity\Designation;
use App\Form\DesignationType;
use App\Repository\DesignationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/designation")
 */
class DesignationController extends AbstractController
{
    /**
     * @Route("/", name="designation_index", methods={"GET"})
     */
    public function index(DesignationRepository $designationRepository): Response
    {
        return $this->render('designation/index.html.twig', [
            'designations' => $designationRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="designation_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $designation = new Designation();
        $form = $this->createForm(DesignationType::class, $designation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($designation);
            $entityManager->flush();

            return $this->redirectToRoute('designation_index');
        }

        return $this->render('designation/new.html.twig', [
            'designation' => $designation,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="designation_show", methods={"GET"})
     */
    public function show(Designation $designation): Response
    {
        return $this->render('designation/show.html.twig', [
            'designation' => $designation,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="designation_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Designation $designation): Response
    {
        $form = $this->createForm(DesignationType::class, $designation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('designation_index');
        }

        return $this->render('designation/edit.html.twig', [
            'designation' => $designation,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="designation_delete", methods={"POST"})
     */
    public function delete(Request $request, Designation $designation): Response
    {
        if ($this->isCsrfTokenValid('delete'.$designation->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($designation);
            $entityManager->flush();
        }

        return $this->redirectToRoute('designation_index');
    }
}
