<?php

namespace App\Controller;

use App\Entity\NorlogFolder;
use App\Form\NorlogFolderType;
use App\Repository\NorlogFolderRepository;
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

            $folder = $form->getData();

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($folder);
            $entityManager->flush();

            return $this->redirectToRoute('folder_list');
        }

        return $this->render('folder/new.html.twig', [
            'folder' => $folder,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/delete/{id}", name="folder_delete")
     */
    public function delete(Request $request): Response
    {
        //TODO
    }

    /**
     * @Route("/edit/{id}", name="folder_edit")
     */
    public function edit(Request $request, NorlogFolder $folder): Response
    {
        $form = $this->createForm(NorlogFolderType::class, $folder);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $folder = $form->getData();

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($folder);
            $entityManager->flush();

            return $this->redirectToRoute('folder_list');
        }

        return $this->render('folder/index.html.twig', [
            'folder' => $folder,
            'form' => $form->createView()
        ]);
    }
}