<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\User;
use App\Entity\Image;
use App\Entity\Annonce;
use App\Entity\Booking;
use App\Entity\Role;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private $encoder;
    public function __construct(UserPasswordHasherInterface $encoder){
        $this->encoder = $encoder;
    }
    public function load(ObjectManager $manager): void
    {
        $faker = Factory ::create("FR-fr");

        //UN administrateur 
        $adminRole = new Role();
        $adminRole->setTitle('ROLE_ADMIN');
        $manager->persist($adminRole);
        $admin = new User();
        $admin->setLastName('RASOLONJATOVO')
            ->setFirstName('Pierre Admin')
            ->setEmail('tovo2424@outlook.fr')
            ->setPicture('https://randomuser.me/api/portraits')
            ->setIntroduction($faker->sentence())
            ->setDescription('<p>Je suis l\'administrateur du site, je suis là pour vous aider et vous accompagner dans votre expérience.</p>')
            ->setHash($this->encoder->hashPassword($admin, 'password'))
            ->addUserRole($adminRole);
        $manager->persist($admin);
        //On ajoute l'administrateur dans la base de données
        $manager->flush();
        //Ici on gère les fixtures des utilisateurs
        $users = [];
        $gender = ['men', 'women'];
        for($i = 0; $i< 10 ; $i++){
            $desc = '<p>'.join('</p><p>', $faker->paragraphs(5)).'</p>';
            $pic = "https://randomuser.me/api/portraits/" . $gender[mt_rand(0, 1)] . "/" . ($i + 1) . ".jpg";
            $user = new User();
            $hash = $this->encoder->hashPassword($user, 'password');
            $user->setLastName($faker->lastname)
                ->setFirstName($faker->firstName)
                ->setEmail($faker->email)
                ->setPicture($pic)
                ->setIntroduction($faker->sentence())
                ->setDescription($desc)
                ->setHash($hash);

            $manager->persist($user);
            $users[$i] = $user;
        }

        // Ici on gère les fixtures des annonces
        for ($i=0; $i < 20; $i++) {
            $author = new User();
            $author = $users[mt_rand(0, 9)];
            $annonce = new Annonce();
            $tittle = $faker->sentence();
            $converImage = 'https://picsum.photos/600/400?random=' . mt_rand(40, 1034);
            $introduction = $faker->paragraph(3);
            $content = '<p>'.join('</p><p>', $faker->paragraphs(5)).'</p>';
            $annonce->setTittle($tittle)
                    ->setPrice(mt_rand(30, 120))
                    ->setIntroduction($introduction)
                    ->setContent($content)
                    ->setConverImage($converImage)
                    ->setRooms(mt_rand(1, 8))
                    ->setAuthor($author);

            for ($j=0; $j < mt_rand(2, 5); $j++) { 
                $image = new Image();
                $image -> setUrl('https://picsum.photos/600/400?random='. mt_rand(600, 10000))
                        ->setCaption($faker->sentence())
                        ->setAnnonce($annonce);

                $manager->persist($image);
            }

            for ($kj=0; $kj < mt_rand(0, 10); $kj++) { 
                $booking = new Booking();
                $createdAt = \DateTimeImmutable::createFromMutable($faker->dateTimeBetween('-6 months'));
                $startDate = $faker->dateTimeBetween('-3 months');
                $duration = mt_rand(0, 10);
                $endDate = (clone $startDate)->modify("+$duration days");
                $amount = $annonce->getPrice() * $duration;
                if($kj%2 == 0){
                    $comment = $faker->paragraph(2);
                } else {
                    $comment = null;        
                }
                $comment = $faker->paragraph();
                $booker = $users[mt_rand(0, count($users) - 1)];
                $booking->setBooker($booker)
                        ->setBookingAnnonce($annonce)
                        ->setStartDate($startDate)
                        ->setEndDate($endDate)
                        ->setAmount($amount)
                        ->setCreatedAt($createdAt)
                        ->setComment($comment);
                        
                // On s'assure que le booker n'est pas l'auteur de l'annonce
                $manager->persist($booking);    
                
            }

            $manager->persist($annonce);
        }
        $manager->flush();
    }
}
