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

                $manager->persist($sku);
            }
            $manager->persist($folder);
        }
        $manager->flush();
    }
}

