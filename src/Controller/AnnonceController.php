<?php

namespace App\Controller;

use App\Entity\Annonce;
use App\Repository\AnnonceRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AnnonceController extends AbstractController
{
    /**
     * @Route("/annonces", name="annonces")
     */
    public function index(AnnonceRepository $repos): Response
    {
        //$repos = $this->getDoctrine()->getRepository(Annonce::class);
        $annonces = $repos->findAll();
        return $this->render('annonce/index.html.twig', [
            'annonces' => $annonces
        ]);
    }

    /**
     * Cette fonction permet visualiser une annonce
     * @Route("/annonces/{slug}", "annonce_show")
     * @return Response
     */
    public function show($slug, AnnonceRepository $repos):Response
    {
        $annonce = $repos->findOneBySlug($slug);
        return $this->render('annonce/show.html.twig', [
            'annonce'=> $annonce
        ]);
    }
}
