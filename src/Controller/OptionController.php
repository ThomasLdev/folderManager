<?php

namespace App\Controller;

use App\Entity\Option;
use App\Entity\Value;
use App\Form\LinkOptionType;
use App\Form\OptionAddType;
use App\Form\OptionType;
use App\Repository\NorlogFolderRepository;
use App\Repository\OptionRepository;
use App\Repository\SkuRepository;
use App\Repository\TypeRepository;
use App\Repository\ValueRepository;
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
	 * @Route("/sku/add/option/", name="link_sku_option")
	 */
	public function linkToSku(TypeRepository $typeRepository, ValueRepository $valueRepository, Request $request, SkuRepository $skuRepository) : Response
	{
		$sku = $skuRepository->find($request->get('id'));
		$option = new Option();

		if ($request->isMethod('POST')) {
			$entityManager = $this->getDoctrine()->getManager();

			$type = $typeRepository->findBy(['name' => $request->get('type')]);
			$value = $valueRepository->findBy(['name' => $request->get('value')]);

			$option->setType($type[0]);
			$option->setValue($value[0]);
			$entityManager->persist($option);

			$sku->addOption($option);
			$entityManager->flush();

			return $this->redirectToRoute('folder_edit', ['id' => $sku->getFolder()->getId()]);
		}

		return $this->render('/option/associateSkuForm.html.twig', [
			'types'     => $typeRepository->findAll(),
			'values'    => $valueRepository->findAll(),
			'folderId'    => $sku->getFolder()->getId()
		]);
	}

	/**
	 * @Route("/sku/remove/option", name="remove_sku_option")
	 */
	public function dissociateOptionSku(Request $request, SkuRepository $skuRepository, OptionRepository $optionRepository) : Response
	{
		$sku = $skuRepository->find($request->get('skuId'));
		$sku->removeOption($optionRepository->find($request->get('optionId')));

		$entityManager = $this->getDoctrine()->getManager();
		$entityManager->flush();

		return $this->redirectToRoute('folder_edit', ['id' => $sku->getFolder()->getId()]);
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