<?php
namespace App\Controller;
use App\Entity\Folder;
use App\Entity\Option;
use App\Form\FolderType;
use App\Form\OptionType;
use App\Repository\FolderRepository;
use App\Repository\OptionRepository;
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
            $entityManager->persist($folder);
            $entityManager->flush();

            return $this->redirectToRoute('folder_index');

        }
        return $this->render('folder/new.html.twig', [
            'folder' => $folder,
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
            $folder->setCreatedAt(new \DateTime())
                ->setExported(false);
            $this->getDoctrine()->getManager()->flush();
            return $this->redirectToRoute('folder_index');
        }
        return $this->render('folder/edit.html.twig', [
            'folder' => $folder,
            'form' => $form->createView(),
        ]);
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
    /**
     * @Route("/option-list", name="option_list")
     */
    public function optionList(): Response
    {
        return $this->render('folder/option-list.html.twig');
    }
}