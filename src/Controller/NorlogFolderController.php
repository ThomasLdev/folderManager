<?php

namespace App\Controller;

use App\Entity\NorlogFolder;
use App\Form\NorlogFolderType;
use App\Repository\NorlogFolderRepository;
use App\Repository\SkuRepository;
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
    public function list(NorlogFolderRepository $folderRepository): Response
    {
        return $this->render('folder/index.html.twig', [
            'norlogFolders' => $folderRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="folder_new")
     */
    public function new(Request $request): Response
    {
        $norlogFolder = new NorlogFolder();

        $form = $this->createForm(NorlogFolderType::class, $norlogFolder);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            foreach ($norlogFolder->getSkus() as $sku) {
                $sku->setFolder($norlogFolder);
                $sku->setSKU($norlogFolder->getNorlogReference().'-'.$sku->getSKU());
            }
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($norlogFolder);
            $entityManager->flush();

            return $this->redirectToRoute('folder_edit', ['id' => $norlogFolder->getId()]);
        }

        return $this->render('folder/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/dissociateSku/{id}", name="folder_delete")
     */
    public function dissociateSku(Request $request, NorlogFolder $norlogFolder, SkuRepository $skuRepository): Response
    {
        //TODO
    }

    /**
     * @Route("/edit/{id}", name="folder_edit")
     */
    public function edit(Request $request, NorlogFolder $norlogFolder): Response
    {
        $form = $this->createForm(NorlogFolderType::class, $norlogFolder);
        $form->handleRequest($request);

        $folderSkus = $norlogFolder->getSkus();

        if ($form->isSubmitted() && $form->isValid()) {

            $norlogFolder = $form->getData();

            foreach ($norlogFolder->getSkus() as $sku) {
                $sku->setFolder($norlogFolder);
                $sku->setSKU($norlogFolder->getNorlogReference().'-'.$sku->getSKU());
            }
            
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($norlogFolder);
            $entityManager->flush();

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($norlogFolder);
            $entityManager->flush();

            return $this->redirectToRoute('folder_edit', ['id' => $norlogFolder->getId()]);
        }

        return $this->render('folder/edit.html.twig', [
            'norlogFolder'    => $norlogFolder,
            'skus'      => $folderSkus,
            'form'      => $form->createView()
        ]);
    }
}