<?php

namespace App\Controller;

use App\Entity\Annonce;
use App\Form\AnnonceType;
use App\Repository\AnnonceRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
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
     * Permet de creer une annonce
     * @Route("/annonces/creer", "annonce_new")
     */
    public function new(): Response
    {
        $annonce = new Annonce();
        $form = $this->createForm(AnnonceType::class);
        return $this->render('annonce/new.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * Cette fonction permet visualiser une annonce
     * @Route("/annonces/{slug}", name="annonce_show")
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
