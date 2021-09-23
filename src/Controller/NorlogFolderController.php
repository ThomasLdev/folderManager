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
            'folders' => $folderRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="folder_new")
     */
    public function new(Request $request): Response
    {
        $folder = new NorlogFolder();

        $form = $this->createForm(NorlogFolderType::class, $folder);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            foreach ($folder->getSkus() as $sku) {
                $sku->setFolder($folder);
            }
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($folder);
            $entityManager->flush();

            return $this->redirectToRoute('folder_list');
        }

        return $this->render('folder/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/dissociateSku/{id}", name="folder_dissociate_sku")
     */
    public function dissociateSku(Request $request, NorlogFolder $norlogFolder, SkuRepository $skuRepository): Response
    {
        $sku = $skuRepository->findBy(['SKU' => $request->get('sku')]);
        $norlogFolder->removeSku($sku[0]);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($norlogFolder);
        $entityManager->flush();

        return $this->redirectToRoute('folder_edit', ['id' => $norlogFolder->getId()]);
    }

    /**
     * @Route("/edit/{id}", name="folder_edit")
     */
    public function edit(Request $request, NorlogFolder $folder): Response
    {
        $form = $this->createForm(NorlogFolderType::class, $folder);
        $form->handleRequest($request);

        $folderSkus = $folder->getSkus();

        if ($form->isSubmitted() && $form->isValid()) {

            $folder = $form->getData();

            foreach ($folder->getSkus() as $sku) {
                $sku->setFolder($folder);
            }
            
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($folder);
            $entityManager->flush();

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($folder);
            $entityManager->flush();

            return $this->redirectToRoute('folder_edit', ['id' => $folder->getId()]);
        }

        return $this->render('folder/edit.html.twig', [
            'folder'    => $folder,
            'skus'      => $folderSkus,
            'form'      => $form->createView()
        ]);
    }
}