<?php
// src/DataFixtures/AnnonceFixtures.php
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

class AnnonceFixtures extends Fixture
{
    private $encoder;
    
    // Injection du service dans le constructeur
    public function __construct(UserPasswordHasherInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create("FR-fr");

        // Création d'un administrateur (exemple)
        $adminRole = new Role();
        $adminRole->setTitle('ROLE_ADMIN');
        $manager->persist($adminRole);


        // Rôle agent (en anglais)
        $agentRole = new Role();
        $agentRole->setTitle('ROLE_AGENT');
        $manager->persist($agentRole);

        // Rôle formateur (en anglais)
        $trainerRole = new Role();
        $trainerRole->setTitle('ROLE_TRAINER');
        $manager->persist($trainerRole);

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
        
        // Création des utilisateurs
        $users = [];
        $gender = ['men', 'women'];
        for ($i = 0; $i < 10; $i++) {
            $desc = '<p>' . join('</p><p>', $faker->paragraphs(5)) . '</p>';
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

        // Création des annonces
        for ($i = 0; $i < 20; $i++) {
            $author = $users[mt_rand(0, 9)];
            $annonce = new Annonce();
            $tittle = $faker->sentence();
            $converImage = 'https://picsum.photos/600/400?random=' . mt_rand(40, 1034);
            $introduction = $faker->paragraph(3);
            $content = '<p>' . join('</p><p>', $faker->paragraphs(5)) . '</p>';
            $annonce->setTittle($tittle)
                    ->setPrice(mt_rand(30, 120))
                    ->setIntroduction($introduction)
                    ->setContent($content)
                    ->setConverImage($converImage)
                    ->setRooms(mt_rand(1, 8))
                    ->setAuthor($author);

            for ($j = 0; $j < mt_rand(2, 5); $j++) {
                $image = new Image();
                $image->setUrl('https://picsum.photos/600/400?random=' . mt_rand(600, 10000))
                      ->setCaption($faker->sentence())
                      ->setAnnonce($annonce);

                $manager->persist($image);
            }

            for ($kj = 0; $kj < mt_rand(0, 10); $kj++) {
                $booking = new Booking();
                $createdAt = \DateTimeImmutable::createFromMutable($faker->dateTimeBetween('-6 months'));
                $startDate = $faker->dateTimeBetween('-3 months');
                $duration = mt_rand(0, 10);
                $endDate = (clone $startDate)->modify("+$duration days");
                $amount = $annonce->getPrice() * $duration;
                $comment = $faker->paragraph();
                $booker = $users[mt_rand(0, count($users) - 1)];
                $booking->setBooker($booker)
                        ->setBookingAnnonce($annonce)
                        ->setStartDate($startDate)
                        ->setEndDate($endDate)
                        ->setAmount($amount)
                        ->setCreatedAt($createdAt)
                        ->setComment($comment);

                $manager->persist($booking);
            }

            $manager->persist($annonce);
        }
        $manager->flush();
    }
}
