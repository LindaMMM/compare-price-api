<?php

namespace App\DataFixtures;

use App\Entity\Bank;
use App\Entity\Brand;
use App\Entity\Category;
use App\Entity\Ensign;
use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // ----------Category-------------
        $cat1 = new Category();
        $cat1->setName("mobile");
        $manager->persist($cat1);
        $cat2 = new Category();
        $cat2->setName("Lave-linge");
        $manager->persist($cat2);
        $cat3 = new Category();
        $cat3->setName("Frigo");
        $manager->persist($cat3);
        $cat3->setName("Réfrigérateur");
        $manager->persist($cat3);
        // ----------Brand-------------
        $band1 = new Brand();
        $band1->setName("Samsung");
        $manager->persist($band1);
        $band2 = new Brand();
        $band2->setName("Xiaomi");
        $manager->persist($band2);
        $band3 = new Brand();
        $band3->setName("Apple");
        $manager->persist($band3);
        $band4 = new Brand();
        $band4->setName("Thomson");
        $manager->persist($band4);
        // -------Enseign---------------------
        $darty = new Ensign();
        $darty->setName("Darty");
        $darty->setUrl("https://www.darty.com");
        $manager->persist($darty);
        $boulanger = new Ensign();
        $boulanger->setName("Boulanger");
        $boulanger->setUrl("https://www.boulanger.com");
        $manager->persist($boulanger);
        $amazon = new Ensign();
        $amazon->setName("Amazone");
        $amazon->setUrl("https://www.amazon.com");
        $manager->persist($amazon);

        // ----------product-------------
        $prod1 = new Product();
        $prod1->setName("Lave-linge hublot");
        $prod1->setRefProduct("tw148am10whcs");
        $prod1->setMedia("tw148am10whcs.jpg");
        $prod1->setContent("Les points forts

    Capacité 8 Kg (4 personnes) - 72 dB
    Essorage jusqu' à 1400 trs/min
    LxHxP : 60 x 85 x 54 cm
    10 programmes - Volume du tambour 57 L
");
        $prod1->setSearchs(array('tw148am10whcs', 'Lave-linge'));
        $prod1->setCategory($cat2);
        $prod1->setBrand($band4);
        $manager->persist($prod1);

        $prod2 = new Product();
        $prod2->setName("iPhone 16e 6,1");
        $prod2->setRefProduct("iPhone 16e");
        $prod2->setMedia("iPhone-16e.jpg");
        $prod2->setContent(
            'Les points forts

    iOS 18 128 Go de ROM
    Écran Super Retina XDR, OLED tout écran de 6,1 pouces (diagonale)
    Puce A18, Nouveau CPU 6 cœurs, Nouveau GPU 4 cœurs, Nouveau Neural Engine 16 cœurs
    Système caméra 2‑en‑1, Caméra Fusion 48 Mpx, Avec téléobjectif 2x 12 Mpx
    Apple iPhone 16e 6,1" 5G Double SIM 128 Go Noir 
'
        );
        $prod2->setSearchs(array('5G', 'Double SIM', '128 Go', "Noir", '6,1"'));
        $prod2->setCategory($cat1);
        $prod2->setBrand($band3);


        $prod3 = new Product();
        $prod3->setName("Redmi Note 14 Pro");
        $prod3->setRefProduct("Note 14 Pro");
        $prod3->setMedia("Note-14.jpg");
        $prod3->setContent(
            'Les points forts

    OS HyperOS basé sur Android 14 - 256Go de ROM, 8Go de RAM
    Écran AMOLED FHD+ incurvé de 6,67’’
    Processeur MediaTek Helio G100-Ultra
    Objectif principal de 200MP + Objectif ultra grand angle de 8MP + Objectif macro de 2MP + Caméra selfie de 32MP

'
        );
        $prod3->setSearchs(array('8/256', 'Midnight Black', 'Xiaomi', "Redmi Note 14 Pro"));
        $prod3->setCategory($cat1);
        $prod3->setBrand($band2);

        $manager->persist($prod3);


        $prod4 = new Product();
        $prod4->setName("S24 Ultra 256Go");
        $prod4->setRefProduct("S24 Ultra");
        $prod4->setMedia("S24.jpg");
        $prod4->setContent(
            'Les points forts

    OS Android 14 - 256 Go de ROM, 12 Go de RAM
    Écran Infinity-O 6.8" QHD+ 120Hz
    Processeur Qualcomm Snapdragon 8 Gen3
    Un système photo composé de 5 capteurs - Galaxy AI est là


'
        );
        $prod4->setSearchs(array('Samsung', '256Go', 'Noir', "EE", "S24 Ultra"));
        $prod4->setCategory($cat1);
        $prod4->setBrand($band1);

        $manager->persist($prod4);


        $manager->flush();
    }
}
