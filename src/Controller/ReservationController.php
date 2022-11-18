<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use App\Entity\Reservation;
use App\Repository\UserRepository;
use App\Repository\CarRepository;
use Doctrine\ORM\EntityManagerInterface;

class ReservationController extends AbstractController
{
    #[Route('/reservation/new/{userId}/{carId}', name: 'reservation-create')]
    public function create(UserRepository $repoUser,CarRepository $repoCar,$userId,$carId,Request $request,EntityManagerInterface $manager): Response
    {
        $reservation=new Reservation();
        $user=$repoUser->findOneById($userId);
        $car=$repoCar->findOneById($carId);
        $reservation->setUser($user);
        $reservation->setCar($car);
        $form=$this->createFormBuilder($reservation)
                   ->add("nbJour",IntegerType::class)
                   ->add("dateRes",DateType::class) 
                   ->getForm();

        $form->handleRequest($request);
        if( $form->isSubmitted() &&  $form->isValid()){
            // dd($reservation);
            $manager->persist($reservation);
            $manager->flush();
            
           // return $this->redirectToRoute("",[""=>""]);
        }
        return $this->render('reservation/index.html.twig', [
            'title' => 'Reservation',
            'formReservation'=> $form->createView()
        ]);
    }
}
