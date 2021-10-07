<?php

namespace App\DataFixtures;

use App\Entity\Composition;
use App\Entity\Couleur;
use App\Entity\Designation;
use App\Entity\Etat;
use App\Entity\Marque;
use App\Entity\NorlogFolder;
use App\Entity\Sku;
use App\Entity\Taille;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
	public function load(ObjectManager $manager)
	{
		$marques = [];
		$compositions = [];
		$couleurs = [];
		$designations = [];
		$etats = [];
		$tailles = [];

		// OPTIONS
		for ($i = 0; $i < 5; $i++) {
			$marque = new Marque();
			$marque->setName('Marque-test-'.$i);
			$manager->persist($marque);
			array_push($marques, $marque);

			$composition = new Composition();
			$composition->setName('Compo-test-'.$i);
			$manager->persist($composition);
			array_push($compositions, $composition);

			$couleur = new Couleur();
			$couleur->setName('Couleur-test-'.$i);
			$manager->persist($couleur);
			array_push($couleurs, $couleur);

			$designation = new Designation();
			$designation->setName('Designation-test-'.$i);
			$manager->persist($designation);
			array_push($designations, $designation);

			$etat = new Etat();
			$etat->setName('Etat-test-'.$i);
			$manager->persist($etat);
			array_push($etats, $etat);

			$taille = new Taille();
			$taille->setName('Taille-test-'.$i);
			$manager->persist($taille);
			array_push($tailles, $taille);
		}

		// FOLDERS
		for ($i = 0; $i < 35; $i++) {
			$folder = new NorlogFolder();
			$folder->setNorlogReference('XOTP-' . rand(1, 1000));
			// FOLDER'S DUMMY SKUS
			for ($a = 0; $a < 10; $a++) {
				$sku = new Sku();
				$sku->setSKU($folder->getNorlogReference() . '-' . rand(65, 8965));
				$sku->setFolder($folder);
				// RANDOM OPTIONS
				$sku->setMarque($marques[rand(0,4)]);
				$sku->setComposition($compositions[rand(0,4)]);
				$sku->setCouleur($couleurs[rand(0,4)]);
				$sku->setDesignation($designations[rand(0,4)]);
				$sku->setEtat($etats[rand(0,4)]);
				$sku->setTaille($tailles[rand(0,4)]);
				$sku->setPicture1('/media/image-holder.jpeg');
				$sku->setPicture2('/media/image-holder.jpeg');
				$manager->persist($sku);
			}
			$manager->persist($folder);
		}
		$manager->flush();
	}
}

