<?php

namespace App\DataFixtures;

use App\Entity\Grille;
use App\Entity\Rubrique;
use App\Entity\Critere;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class GrilleFixtures extends Fixture
{
    public function load(ObjectManager $manager) : void
    {
        // Création de la grille de base
        $grilleBase = new Grille();
        $grilleBase->setTitre("Grille de qualité de base");

        // Création des rubriques et critères pour chaque catégorie

        // Rubrique "Accueil"
        $accueil = new Rubrique();
        $accueil->setTitre("Accueil");
        $accueil->setGrille($grilleBase);
        
        $accueilRespectFormule = new Critere();
        $accueilRespectFormule->setTitre("Respect de la formule");
        $accueilRespectFormule->setRubrique($accueil);

        $identification = new Critere();
        $identification->setTitre("Identification");
        $identification->setRubrique($accueil);

        $formuleTransition = new Critere();
        $formuleTransition->setTitre("Formule de transition");
        $formuleTransition->setRubrique($accueil);

        // Rubrique "Decouverte"
        $decouverte = new Rubrique();
        $decouverte->setTitre("Decouverte");
        $decouverte->setGrille($grilleBase);
        
        $methodologieQuestionnement = new Critere();
        $methodologieQuestionnement->setTitre("Respect de la méthode de questionnement");
        $methodologieQuestionnement->setRubrique($decouverte);

        $reformulationConfirmation = new Critere();
        $reformulationConfirmation->setTitre("Reformulation/ confirmation de la demande");
        $reformulationConfirmation->setRubrique($decouverte);

        $formuleTransitionDecouverte = new Critere();
        $formuleTransitionDecouverte->setTitre("Formule de transition");
        $formuleTransitionDecouverte->setRubrique($decouverte);

        // Rubrique "Traitement"
        $traitement = new Rubrique();
        $traitement->setTitre("Traitement");
        $traitement->setGrille($grilleBase);
        
        $respectEtapes = new Critere();
        $respectEtapes->setTitre("Respect des étapes");
        $respectEtapes->setRubrique($traitement);

        $respectProcedures = new Critere();
        $respectProcedures->setTitre("Respect des procédures");
        $respectProcedures->setRubrique($traitement);

        // Rubrique "Gestion MEA"
        $gestionMea = new Rubrique();
        $gestionMea->setTitre("gestion_MEA");
        $gestionMea->setGrille($grilleBase);
        
        $respectFormuleMea = new Critere();
        $respectFormuleMea->setTitre("Respect de la formule MEA");
        $respectFormuleMea->setRubrique($gestionMea);

        $dureeMea = new Critere();
        $dureeMea->setTitre("Durée MEA");
        $dureeMea->setRubrique($gestionMea);

        $respectNombreMaxMea = new Critere();
        $respectNombreMaxMea->setTitre("Respect du nombre maximum de MEA");
        $respectNombreMaxMea->setRubrique($gestionMea);

        // Rubrique "Closing"
        $closing = new Rubrique();
        $closing->setTitre("Closing");
        $closing->setGrille($grilleBase);

        $recapActions = new Critere();
        $recapActions->setTitre("Recapitulatif des actions");
        $recapActions->setRubrique($closing);

        $check360 = new Critere();
        $check360->setTitre("Check 360");
        $check360->setRubrique($closing);

        $respectFormuleClosing = new Critere();
        $respectFormuleClosing->setTitre("Respect de la formule de closing");
        $respectFormuleClosing->setRubrique($closing);

        // Rubrique "Qualité de l'échange"
        $qualiteEchange = new Rubrique();
        $qualiteEchange->setTitre("Qualite_d_echange");
        $qualiteEchange->setGrille($grilleBase);

        $nvFrancais = new Critere();
        $nvFrancais->setTitre("Niveau de français");
        $nvFrancais->setRubrique($qualiteEchange);

        $gestionBlancs = new Critere();
        $gestionBlancs->setTitre("Gestion des blancs");
        $gestionBlancs->setRubrique($qualiteEchange);

        $utilisationPresent = new Critere();
        $utilisationPresent->setTitre("Utilisation du présent");
        $utilisationPresent->setRubrique($qualiteEchange);

        // Enregistrement des objets
        $manager->persist($grilleBase);
        $manager->persist($accueil);
        $manager->persist($identification);
        $manager->persist($formuleTransition);
        $manager->persist($decouverte);
        $manager->persist($methodologieQuestionnement);
        $manager->persist($reformulationConfirmation);
        $manager->persist($formuleTransitionDecouverte);
        $manager->persist($traitement);
        $manager->persist($respectEtapes);
        $manager->persist($respectProcedures);
        $manager->persist($gestionMea);
        $manager->persist($respectFormuleMea);
        $manager->persist($dureeMea);
        $manager->persist($respectNombreMaxMea);
        $manager->persist($closing);
        $manager->persist($recapActions);
        $manager->persist($check360);
        $manager->persist($respectFormuleClosing);
        $manager->persist($qualiteEchange);
        $manager->persist($nvFrancais);
        $manager->persist($gestionBlancs);
        $manager->persist($utilisationPresent);

        // Flush pour sauvegarder
        $manager->flush();
    }
}
