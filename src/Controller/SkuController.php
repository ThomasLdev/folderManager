<?php

namespace App\Controller;

use App\Entity\Sku;
use App\Entity\Option;
use App\Form\SkuType;
use App\Form\OptionType;
use App\Repository\SkuRepository;
use App\Repository\OptionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/sku")
 */
class SkuController extends AbstractController
{
    /**
     * @Route("/search", name="sku_search")
     */
    public function search(Request $request): Response
    {
        $editId = $request->request->get('id');

        //check si l'id est bien un nombre
        if (is_numeric($editId)){
            return $this->redirectToRoute('sku_edit', ['id' => (int) $editId]);
        }
        else
        {
            return $this->render('sku/index.html.twig', [
                'error' => 'Veuillez entrer un nombre'
            ]);
        }
    }

    /**
     * @Route("/new", name="sku_new")
     */
    public function new(Request $request): Response
    {
        $Sku = new Sku();

        $typeNames = ['Designation', 'Taille', 'Marque', 'Composition', 'Etat', 'Couleur', 'Type'];
        $options = [];

        foreach ($typeNames as $typeName)
        {
            $values = $this->getDoctrine()->getRepository(Option::class)->findDistinctByType($typeName);
            array_unshift($values, new Option());
            $options += [$typeName => $values];

            $option = new Option();
            $option->setType($typeName);
            $Sku->getOptions()->add($option);
        }

        $form = $this->createForm(SkuType::class, $Sku);
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

                $Sku->setPicture1($newFilename1);

            } else {

                $Sku->setPicture1("empty");

            }
            if ($uploadedFile2) {

                $destination = $this->getParameter('kernel.project_dir').'/public/uploads';
                $originalFilename2 = pathinfo($uploadedFile2->getClientOriginalName(), PATHINFO_FILENAME);
                $newFilename2 = $originalFilename2.'-'.uniqid().'.'.$uploadedFile2->guessExtension();

                $uploadedFile2->move(
                    $destination,
                    $newFilename2
                );

                $Sku->setPicture2($newFilename2);

            } else {

                $Sku->setPicture2("empty");

            }

            $Sku ->setCreatedAt(new \DateTime())
                ->setExported(false);

            foreach ($Sku->getOptions() as $SkuOption)
            {
                if ($SkuOption->getValue() === null){
                    $SkuOption->setValue('');
                }
                $queryResult = $this->getDoctrine()->getRepository(Option::class)->findOneByValueAndType($SkuOption->getType(), $SkuOption->getValue());
                if ($queryResult != null)
                {
                    $Sku->getOptions()->removeElement($SkuOption);
                    $Sku->getOptions()->add($queryResult);
                }
            }
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($Sku);
            $entityManager->flush();

            return $this->redirectToRoute('sku_list');

        }
        return $this->render('sku/new.html.twig', [
            'sku' => $Sku,
            'options' => $options,
            'form' => $form->createView(),
        ]);
    }
    /**
     * @Route("/list", name="sku_list", methods={"GET"})
     */
    public function SkuList(SkuRepository $SkuRepository): Response
    {
        return $this->render('sku/index.html.twig', [
            'skus' => $SkuRepository->findAll(),
        ]);
    }

    /**
     * @Route("/{id}/edit", name="sku_edit")
     */
    public function edit(Request $request, Sku $Sku = null): Response
    {
        if ($Sku == null)
        {
            return $this->render('sku/index.html.twig', [
                'error' => 'Veuillez entrer un numéro de dossier existant'
            ]);
        }

        $typeNames = ['Designation', 'Taille', 'Marque', 'Composition', 'Etat', 'Couleur', 'Type'];
        $optionsString = [];
        $tmpOptions = [];

        foreach ($typeNames as $typeName)
        {
            $values = $this->getDoctrine()->getRepository(Option::class)->findDistinctByType($typeName);

            $shiftedOption = new Option();

            foreach ($Sku->getOptions() as $SkuOption)
            {
                if ($SkuOption->getType() === $typeName)
                {
                    $shiftedOption = $SkuOption;
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

        $Sku->getOptions()->clear();

        foreach ($tmpOptions as $option)
        {
            $Sku->getOptions()->add($option);
        }

        $form = $this->createForm(SkuType::class, $Sku);
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

                $Sku->setPicture1($newFilename1);

            } else {

                $Sku->setPicture1("empty");

            }
            if ($uploadedFile2) {

                $destination = $this->getParameter('kernel.project_dir').'/public/uploads';
                $originalFilename2 = pathinfo($uploadedFile2->getClientOriginalName(), PATHINFO_FILENAME);
                $newFilename2 = $originalFilename2.'-'.uniqid().'.'.$uploadedFile2->guessExtension();

                $uploadedFile2->move(
                    $destination,
                    $newFilename2
                );

                $Sku->setPicture2($newFilename2);

            } else {

                $Sku->setPicture2("empty");

            }

            $Sku ->setCreatedAt(new \DateTime())
                ->setExported(false);

            $entityManager = $this->getDoctrine()->getManager();
            foreach ($Sku->getOptions() as $SkuOption)
            {
                if ($SkuOption->getValue() === null){
                    $SkuOption->setValue('');
                }
                $persistedOption = $this->getDoctrine()->getRepository(Option::class)->findOneByValueAndType($SkuOption->getType(), $SkuOption->getValue());
                if ($persistedOption){
                    $Sku->getOptions()->removeElement($SkuOption);
                    $Sku->getOptions()->add($persistedOption);
                }
            }

            $entityManager->persist($Sku);
            $entityManager->flush();

            return $this->redirectToRoute('sku_list');

        }
        return $this->render('sku/edit.html.twig', [
            'sku' => $Sku,
            'options' => $optionsString,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/sku-export/", name="sku_export", methods={"POST"})
     */
    public function SkuExport(Request $request): Response
    {
        $entityManager = $this->getDoctrine()->getManager();

        $SkuIds = $request->request->all();

        $SkuRows = ['ID;SKU;Photo_1;Photo_2;Date;Marque;Couleur;Composition;Designation;Taille;Etat;Type'];

        foreach ($SkuIds as $SkuId)
        {
            $Sku = $this->getDoctrine()->getRepository(Sku::class)->find($SkuId);
            $SkuEntry = [
                $Sku->getId(),
                $Sku->getSKU(),
                ($Sku->getPicture1() == 'empty') ? 'empty' : 'https://' . $request->getHost().'/uploads/'.$Sku->getPicture1(),
                ($Sku->getPicture2() == 'empty') ? 'empty' : 'https://' . $request->getHost().'/uploads/'.$Sku->getPicture2(),
                $Sku->getCreatedAt()->format('Y-m-d'),
            ];
            $options = $Sku->getOptions()->toArray();
            usort($options, function ($a, $b) { return strcasecmp($a->getType(), $b->getType()); });

            foreach ($options as $option)
            {
                array_push($SkuEntry, ($option->getValue() != '') ? $option->getValue() : 'none');
            }
            $SkuRows[] = implode(';', $SkuEntry);
            $Sku->setExported(true);

            $entityManager->persist($Sku);
        }
        $entityManager->flush();

        $SkuCSV = implode("\n", $SkuRows);
        $response = new Response($SkuCSV);
        $response->headers->set('Content-Type', 'text/csv');

        return $response;
    }

    /**
     * @Route("/delete/{id}", name="sku_delete")
     */
    public function SkuDelete(Request $request, Sku $Sku): Response
    {
        if ($this->isCsrfTokenValid('delete'.$Sku->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($Sku);
            $entityManager->flush();
        }
        return $this->redirectToRoute('sku_index');
    }
}