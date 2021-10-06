<?php

namespace App\DataFixtures;

use App\Entity\NorlogFolder;
use App\Entity\Option;
use App\Entity\Sku;
use App\Entity\Type;
use App\Entity\Value;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
	    $types = [
		    'Designation',
		    'Couleur',
		    'Marque',
		    'Taille',
		    'Composition',
		    'Etat',
		    'Type'
	    ];

	    // FOLDERS
	    for ($i = 0; $i < 35; $i++) {
		    $folder = new NorlogFolder();
		    $folder->setNorlogReference('XOTP-' . rand(1, 1000));
		    // FOLDER'S DUMMY SKUS
		    for ($a = 0; $a < 10; $a++) {
			    $sku = new Sku();
			    $sku->setSKU($folder->getNorlogReference() . '-' . rand(65, 8965));
			    $sku->setFolder($folder);
			    $sku->setPicture1('/media/image-holder.jpeg');
			    $sku->setPicture2('/media/image-holder.jpeg');
			    $manager->persist($sku);
		    }
		    $manager->persist($folder);
	    }

		// OPTIONS
	    foreach ($types as $type) {
			$option = new Option();
		    // TYPE
		    $type = new Type();
			$type->setName($type);
			$type->addOption($option);
		    $manager->persist($type);
			// VALUE
		    $value = new Value();
			$value->setType($type);
			$value->setName($this->getRandomString(rand(5,10)));
			$value->addOption($option);
		    $manager->persist($value);

		    $manager->persist($option);

		    $manager->flush();
	    }
    }


	private function getRandomString($n): string
	{
		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$randomString = '';

		for ($i = 0; $i < $n; $i++) {
			$index = rand(0, strlen($characters) - 1);
			$randomString .= $characters[$index];
		}

		return $randomString;
	}
}

