<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Evaluation;
use App\Form\EvaluationType;
use App\Repository\GrilleRepository;
use App\Repository\CritereRepository;
use App\Entity\EvaluationScore;
use Symfony\Component\HttpFoundation\JsonResponse;

class EvaluationController extends AbstractController
{
    #[Route('/evaluation/new', name: 'evaluation_new')]
    public function new(Request $request, EntityManagerInterface $em, GrilleRepository $grilleRepo, CritereRepository $critereRepo): Response
    {
        $evaluation = new Evaluation();

        // 👉 Charger la grille de base (on peut rendre ça dynamique après)
        $grille = $grilleRepo->findOneBy(['titre' => 'Grille de qualité de base']);
        $evaluation->setGrille($grille);

        // 👉 Récupérer tous les critères de cette grille
        $criteres = $critereRepo->findByGrille($grille);

        // 👉 Créer un EvaluationScore pour chaque critère
        foreach ($criteres as $critere) {
            $score = new EvaluationScore();
            $score->setCritere($critere);
            $evaluation->addScore($score);
        }

        // ✅ Création du formulaire
        $form = $this->createForm(EvaluationType::class, $evaluation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Calcul automatique de la note
            $total = 0; $count = 0;
            foreach ($evaluation->getScores() as $s) {
                if ($s->getScore()) {
                    $total += $s->getScore();
                    $count++;
                }
            }
            $evaluation->setNoteTotale($count > 0 ? $total / $count : null);

            $em->persist($evaluation);
            $em->flush();

            $this->addFlash('success', 'Évaluation enregistrée avec succès !');
            return $this->redirectToRoute('evaluation_list');
        }

        return $this->render('evaluation/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }
    #[Route('evaluation/grille/{id}/critere', name:'evaluation_grille_criteres', methods:['GET'])]
    public function getCritereByGrille(int $id, GrilleRepository $grilleRepo) : JsonResponse
    {
        $grille = $grilleRepo->find($id);
        if(!$grille){
            return $this->json(['error'=> 'Grille non trouvé', 404]);
        }
        $rubriques = [];
        foreach($grille->getRubriques() as $rubrique){
            $criteres = [];
            foreach ($$rubrique->getCritere() as $critere) {
                $criteres[] = [
                    'id' => $critere->getId(),
                    'titre' => $critere->getTitre()
                ];
            }
            $rubriques[] = [
                'id' => $rubrique->getId(),
                'titre' => $rubrique->getTitre(),
                'critere' => $criteres,
            ];

        }
        return $this->json($rubriques);
    }
}
