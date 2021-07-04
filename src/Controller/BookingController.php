<?php

namespace App\Controller;


use App\Entity\Car;
use App\Entity\Booking;
use App\Form\BookingType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BookingController extends AbstractController
{
    /**
     * Permet à l'utilisateur conecter de faire une réservation
     * 
     * @Route("/car/{slug}/book", name="booking_car")
     * @IsGranted("ROLE_USER")
     * 
     * @return Response
     */
    public function book(Car $car, Request $request, EntityManagerInterface $manager): Response
    {
        $booking = new Booking();

        $form    = $this->createForm(BookingType::class,$booking);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            
            $user = $this->getUser();

            $booking->setBooker($user)
                    ->setCar($car);

            if($booking->isbookableDates()) {
    
                $manager->persist($booking);
                $manager->flush();
    
                return $this->redirectToRoute('booking_show', ['id' => $booking->getId(), 'withAlert' => true]);
            } else {
                $this->addFlash(
                    "danger",
                    "Le véhicule est déja réserver aux dates choisies"
                );
            }

        }
        return $this->render('booking/book.html.twig', [
            'car' => $car,
            'form' => $form->createView()
        ]);
    }

    /**
     * Permet d'afficher la page d'une réservation
     *
     * @Route("/booking/{id}", name="booking_show")
     * 
     * @param Booking $booking
     * 
     * @return Response
     */
    public function show(Booking $booking) 
    {
        return $this->render('booking/show.html.twig',[
            'booking' => $booking
        ]);

    }
}
