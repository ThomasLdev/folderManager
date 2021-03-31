<?php
namespace App\Controller;
use App\Entity\Folder;
use App\Entity\Option;
use App\Form\FolderType;
use App\Form\OptionType;
use App\Repository\FolderRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FolderController extends AbstractController
{
    /**
     * @Route("/", name="folder_index")
     */
    public function index(): Response
    {
        return $this->render('folder/index.html.twig', [
        ]);
    }
    /**
     * @Route("/new", name="folder_new")
     */
    public function new(Request $request): Response
    {
        $folder = new Folder();

        $typeNames = ['designation', 'size', 'brand', 'composition', 'status', 'color', 'type'];
        $options = [];

        foreach ($typeNames as $typeName)
        {
            $values = $this->getDoctrine()->getRepository(Option::class)->findDistinctByType($typeName);
            array_unshift($values, new Option());
            $options += [$typeName => $values];

            $option = new Option();
            $option->setType($typeName);
            $folder->getOptions()->add($option);
        }

        $form = $this->createForm(FolderType::class, $folder);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $uploadedFile1 = $form['picture_1']->getData();
            $uploadedFile2 = $form['picture_2']->getData();

            if ($uploadedFile1) {

                $destination = $this->getParameter('kernel.project_dir').'/public/uploads';
                $originalFilename1 = pathinfo($uploadedFile1->getClientOriginalName(), PATHINFO_FILENAME);
                $newFilename1 = $originalFilename1.'-'.uniqid().'.'.$uploadedFile1->guessExtension();

                $uploadedFile1->move(
                    $destination,
                    $newFilename1
                );

                $folder->setPicture1($newFilename1);

            } else {

                $folder->setPicture1("empty");

            }
            if ($uploadedFile2) {

                $destination = $this->getParameter('kernel.project_dir').'/public/uploads';
                $originalFilename2 = pathinfo($uploadedFile2->getClientOriginalName(), PATHINFO_FILENAME);
                $newFilename2 = $originalFilename2.'-'.uniqid().'.'.$uploadedFile2->guessExtension();

                $uploadedFile2->move(
                    $destination,
                    $newFilename2
                );

                $folder->setPicture2($newFilename2);

            } else {

                $folder->setPicture2("empty");

            }

            $folder ->setCreatedAt(new \DateTime())
                    ->setExported(false);

            foreach ($folder->getOptions() as $folderOption)
            {
                if ($folderOption->getValue() === null){
                    $folderOption->setValue('');
                }
                $queryResult = $this->getDoctrine()->getRepository(Option::class)->findOneByValueAndType($folderOption->getType(), $folderOption->getValue());
                if ($queryResult != null)
                {
                    $folder->getOptions()->removeElement($folderOption);
                    $folder->getOptions()->add($queryResult);
                }
            }
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($folder);
            $entityManager->flush();

            return $this->redirectToRoute('folder_index');

        }
        return $this->render('folder/new.html.twig', [
            'folder' => $folder,
            'options' => $options,
            'form' => $form->createView(),
        ]);
    }
    /**
     * @Route("/folder-list", name="folder_list", methods={"GET"})
     */
    public function folderList(FolderRepository $folderRepository): Response
    {
        return $this->render('folder/folder-list.html.twig', [
            'folders' => $folderRepository->findAll(),
        ]);
    }
    /**
     * @Route("/search-edit", name="search_edit")
     */
    public function searchEdit(Request $request): Response
    {
        $editId = $request->request->get('id');
        //check si l'id est bien un nombre => à faire
        return $this->redirectToRoute('folder_edit', ['id' => (int) $editId]);
    }
    /**
     * @Route("/{id}/edit", name="folder_edit")
     */
    public function edit(Request $request, Folder $folder): Response
    {
        $typeNames = ['designation', 'size', 'brand', 'composition', 'status', 'color', 'type'];
        $optionsString = [];
        $tmpOptions = [];

        foreach ($typeNames as $typeName)
        {
            $values = $this->getDoctrine()->getRepository(Option::class)->findDistinctByType($typeName);

            $shiftedOption = new Option();

            foreach ($folder->getOptions() as $folderOption)
            {
                if ($folderOption->getType() === $typeName)
                {
                    $shiftedOption = $folderOption;
                }
            }

            array_unshift($values, new Option());

            if ($shiftedOption->getValue())
            {
                unset($values[array_search($shiftedOption, $values)]);
                array_unshift($values, $shiftedOption);
            }

            $optionsString += [$typeName => $values];

            $option = new Option();
            $option->setType($typeName);
            $tmpOptions[] = $option;

        }

        $folder->getOptions()->clear();

        foreach ($tmpOptions as $option)
        {
            $folder->getOptions()->add($option);
        }

        $form = $this->createForm(FolderType::class, $folder);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $uploadedFile1 = $form['picture_1']->getData();
            $uploadedFile2 = $form['picture_2']->getData();

            if ($uploadedFile1) {

                $destination = $this->getParameter('kernel.project_dir').'/public/uploads';
                $originalFilename1 = pathinfo($uploadedFile1->getClientOriginalName(), PATHINFO_FILENAME);
                $newFilename1 = $originalFilename1.'-'.uniqid().'.'.$uploadedFile1->guessExtension();

                $uploadedFile1->move(
                    $destination,
                    $newFilename1
                );

                $folder->setPicture1($newFilename1);

            } else {

                $folder->setPicture1("empty");

            }
            if ($uploadedFile2) {

                $destination = $this->getParameter('kernel.project_dir').'/public/uploads';
                $originalFilename2 = pathinfo($uploadedFile2->getClientOriginalName(), PATHINFO_FILENAME);
                $newFilename2 = $originalFilename2.'-'.uniqid().'.'.$uploadedFile2->guessExtension();

                $uploadedFile2->move(
                    $destination,
                    $newFilename2
                );

                $folder->setPicture2($newFilename2);

            } else {

                $folder->setPicture2("empty");

            }

            $folder ->setCreatedAt(new \DateTime())
                ->setExported(false);

            $entityManager = $this->getDoctrine()->getManager();
            foreach ($folder->getOptions() as $folderOption)
            {
                if ($folderOption->getValue() === null){
                    $folderOption->setValue('');
                }
                $persistedOption = $this->getDoctrine()->getRepository(Option::class)->findOneByValueAndType($folderOption->getType(), $folderOption->getValue());
                if ($persistedOption){
                    $folder->getOptions()->removeElement($folderOption);
                    $folder->getOptions()->add($persistedOption);
                }
            }

            $entityManager->persist($folder);
            $entityManager->flush();

            return $this->redirectToRoute('folder_index');

        }
        return $this->render('folder/edit.html.twig', [
            'folder' => $folder,
            'options' => $optionsString,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/option-list", name="option_list")
     */
    public function optionList(Request $request): Response
    {
        $typeNames = ['designation', 'size', 'brand', 'composition', 'status', 'color', 'type'];

        $option = new Option();

        $form = $this->createForm(OptionType::class, $option);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($option);
            $entityManager->flush();
        }

        return $this->render('folder/option-list.html.twig', [
            'types' => $typeNames,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/folder-export/{id}", name="folder_export", , methods={"GET"})
     */
    public function folderExport(Request $request, Folder $folder): Response
    {

    }

    /**
     * @Route("/{id}", name="folder_delete")
     */
    public function delete(Request $request, Folder $folder): Response
    {
        if ($this->isCsrfTokenValid('delete'.$folder->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($folder);
            $entityManager->flush();
        }
        return $this->redirectToRoute('folder_index');
    }
}