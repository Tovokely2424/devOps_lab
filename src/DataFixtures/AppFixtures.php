<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Image;
use App\Entity\Annonce;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory ::create("FR-fr");

        for ($i=0; $i < 50; $i++) { 
            $annonce = new Annonce();
            $tittle = $faker->sentence();
            $converImage = $faker->imageUrl(1000, 350);
            $introduction = $faker->paragraph(3);
            $content = '<p>'.join('</p><p>', $faker->paragraphs(5)).'</p>';
            $annonce->setTittle($tittle)
                    ->setPrice(mt_rand(30, 120))
                    ->setIntroduction($introduction)
                    ->setContent($content)
                    ->setConverImage($converImage)
                    ->setRooms(mt_rand(1, 8));

            for ($j=0; $j < mt_rand(2, 5); $j++) { 
                $image = new Image();
                $image -> setUrl($faker->imageUrl())
                        ->setCaption($faker->sentence())
                        ->setAnnonce($annonce);

                $manager->persist($image);
            }
            $manager->persist($annonce);
        }
        $manager->flush();
    }
}
