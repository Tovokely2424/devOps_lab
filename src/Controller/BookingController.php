<?php

namespace App\Controller;

use App\Entity\Annonce;
use App\Entity\Booking;
use App\Form\BookingType;
use App\Repository\BookingRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BookingController extends AbstractController
{
    #[Route('/annonces/{slug}/book', name: 'booking_create')]
    #[IsGranted('ROLE_USER', message: 'Vous devez être connecté pour réserver une annonce')]
    public function book(Annonce $annonce, Request $request, EntityManagerInterface $manager): Response
    {
        $booking =  new Booking();
        $form = $this->createForm(BookingType::class, $booking);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $booking->setBooker($this->getUser())
                    ->setBookingAnnonce($annonce);
            if (!$booking->isBookableDates()) {
                $this->addFlash('warning', 'Les dates sélectionnées ne sont pas disponibles.');
                #return $this->redirectToRoute('annonce_show', ['slug' => $annonce->getSlug()]);
            }
            else{
                
                $manager->persist($booking);
                $manager->flush();
                return $this->redirectToRoute('booking_show', ['id' => $booking->getId(), 'success' => true]);
            }
            
        }
        return $this->render('booking/book.html.twig', [
            'annonce' => $annonce,
            'form' => $form->createView(),
        ]);
    }
    #[Route('booking/{id}', name :'booking_show')]
    #[IsGranted('ROLE_USER')]
    public function show(Booking $booking) : Response
    {
        return $this->render('booking/show.html.twig', [
            'booking' => $booking
        ]);
    }
}
