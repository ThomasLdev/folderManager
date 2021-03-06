<?php

namespace App\Controller;

use App\Entity\NorlogFolder;
use App\Entity\Sku;
use App\Form\NorlogFolderType;
use App\Repository\MarqueRepository;
use App\Repository\NorlogFolderRepository;
use App\Repository\SkuRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/folder")
 */
class NorlogFolderController extends AbstractController
{
    /**
     * @Route("/list", name="folder_list")
     */
    public function list(NorlogFolderRepository $folderRepository, PaginatorInterface $paginator, Request $request): Response
    {
		$norlogFolders = $paginator->paginate(
			$folderRepository->findAll(),
			$request->query->getInt('page', 1),
			10
		);

        return $this->render('folder/index.html.twig', [
            'norlogFolders' => $norlogFolders
        ]);
    }

    /**
     * @Route("/new", name="folder_new")
     */
    public function new(Request $request): Response
    {
	    $entityManager = $this->getDoctrine()->getManager();

        $norlogFolder = new NorlogFolder();

        $form = $this->createForm(NorlogFolderType::class, $norlogFolder);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            foreach ($norlogFolder->getSkus() as $sku) {
                $sku->setFolder($norlogFolder);
                $sku->setSKU($norlogFolder->getNorlogReference().'-'.$sku->getSKU());
            }

            $entityManager->persist($norlogFolder);
            $entityManager->flush();

            return $this->redirectToRoute('folder_edit', ['id' => $norlogFolder->getId()]);
        }

        return $this->render('folder/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/dissociateSku/{id}", name="folder_delete_sku")
     * Takes the folder id in params converter
     */
    public function dissociateSku(Request $request, NorlogFolder $norlogFolder, SkuRepository $skuRepository): Response
    {
        $skuToRemove = $skuRepository->find($request->get('skuId'));

		if ($skuToRemove) {
			$norlogFolder->removeSku($skuToRemove);
			$entityManager = $this->getDoctrine()->getManager();
			$entityManager->flush();
		}

		return $this->redirectToRoute('folder_edit', ['id' => $norlogFolder->getId()]);
    }

    /**
     * @Route("/edit/{id}", name="folder_edit")
     */
    public function edit(Request $request, NorlogFolder $norlogFolder): Response
    {
        $form = $this->createForm(NorlogFolderType::class, $norlogFolder);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

	        foreach ($norlogFolder->getSkus() as $sku) {
		        $sku->setFolder($norlogFolder);
	        }

            $norlogFolder = $form->getData();

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($norlogFolder);
            $entityManager->flush();

            return $this->redirectToRoute('folder_edit', ['id' => $norlogFolder->getId()]);
        }

        return $this->render('folder/edit.html.twig', [
            'folderId'      => $norlogFolder->getId(),
            'form'          => $form->createView()
        ]);
    }
}