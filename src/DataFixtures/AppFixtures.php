<?php
// src/DataFixtures/AppFixtures.php
// src/DataFixtures/AppFixtures.php
namespace App\DataFixtures;

use App\DataFixtures\AnnonceFixtures;
use App\DataFixtures\GrilleFixtures;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        // Instanciation et chargement des fixtures des grilles
        $grilleFixtures = new GrilleFixtures();
        $grilleFixtures->load($manager);

        // Instanciation et chargement des fixtures des annonces
        $annonceFixtures = new AnnonceFixtures($this->passwordHasher);
        $annonceFixtures->load($manager);
    }
}
