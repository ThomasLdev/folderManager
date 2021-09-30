<?php

namespace App\Controller;

use App\Entity\Option;
use App\Entity\Value;
use App\Form\OptionAddType;
use App\Form\OptionType;
use App\Repository\OptionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/option")
 */
class OptionController extends AbstractController
{
    /**
     * @Route("/list", name="option_list")
     */
    public function optionList(Request $request, OptionRepository $optionRepository): Response
    {
        $option = new Option();
        $form = $this->createForm(OptionAddType::class, $option);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();

            $oValue = new Value();
            $oValue->setName($form->get('value')->getData());
            $oValue->setType($option->getType());
            $entityManager->persist($oValue);

            $option->setValue($oValue);
            $entityManager->persist($option);
            $entityManager->flush();
        }

        return $this->render('option/index.html.twig', [
            'options' => $optionRepository->findAll(),
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/delete/{id}", name="option_delete")
     */
    public function optionDelete(Request $request, Option $option): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($option);
        $entityManager->flush();

        return $this->redirectToRoute('option_list');
    }
}