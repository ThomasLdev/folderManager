<?php

namespace App\DataFixtures;

use App\Entity\NorlogFolder;
use App\Entity\Option;
use App\Entity\Sku;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
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
                // SKU OPTION 1
                $option1 = new Option();
                $option1->addSku($sku);
                $option1->setType('Color');
                $option1->setValue('Rouge');
                $manager->persist($option1);
                // SKU OPTION 2
                $option2 = new Option();
                $option2->addSku($sku);
                $option2->setType('Taille');
                $option2->setValue('XL');
                $manager->persist($option2);

                $manager->persist($sku);
            }
            $manager->persist($folder);
        }
        $manager->flush();
    }
}

