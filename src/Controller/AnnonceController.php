<?php

namespace App\Controller;

use App\Entity\Image;
use App\Entity\Annonce;
use App\Form\AnnonceType;
use App\Repository\AnnonceRepository;
use Doctrine\Persistence\ObjectManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
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
    public function new(Request $request, EntityManagerInterface $manager): Response
    {
        //$title = $request->resquest->get('title');
        $annonce = new Annonce();
        $form = $this->createForm(AnnonceType::class, $annonce);
        $form->handleRequest($request);
        
        if ($form->isSubmitted($request) && $form->isValid()) {
            //dump($annonce);
            //$manager = $this->getDoctrine()->getManager();
            foreach($annonce->getImages() as $imgOK){
                $imgOK->setAnnonce($annonce);
                $manager->persist($imgOK);
            }
            $manager->persist($annonce);
            $manager->flush();
            $this->addFlash('success', "L'annonce <strong>{$annonce->getSlug()}</strong> a été ajouté avec succès" );
            return $this->redirectToRoute('annonce_show', [
                'slug' => $annonce->getSlug()
            ]);
        }
        
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
        $images = $annonce->getImages();
        return $this->render('annonce/show.html.twig', [
            'annonce'=> $annonce,
            'images'=> $images
        ]);
    }

    /**
     * @Route("/annonces/{slug}/edit", name = "annonce_edit")
     * @param Annonce $annonce
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return Response
     */
    public function edit(Request $request, EntityManagerInterface $manager, $slug): Response
    {
        $annonce = $this->getDoctrine()->getRepository(Annonce::class)->findOneBy(['slug' => $slug]);
        $form = $this->createForm(AnnonceType::class, $annonce);
        $form->handleRequest($request);

        if ($form->isSubmitted($request) && $form->isValid()) {
            //dump($annonce);
            //$manager = $this->getDoctrine()->getManager();
            foreach($annonce->getImages() as $imgOK){
                $imgOK->setAnnonce($annonce);
                $manager->persist($imgOK);
            }
            $manager->persist($annonce);
            $manager->flush();
            $this->addFlash('success', "Les modifications de l'annonce <strong>{$annonce->getSlug()}</strong> a été enregidtrée avec succès" );
            return $this->redirectToRoute('annonce_show', [
                'slug' => $annonce->getSlug()
            ]);
        }

        return $this->render(
            'annonce/edit.html.twig',[
                'annonce' => $annonce,
                'form' => $form->createView()
            ]
            );
    }

   
}
