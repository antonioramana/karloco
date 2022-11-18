<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\CarRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Car;
use App\Entity\User;

class CarController extends AbstractController
{
    #[Route('/car', name: 'car-all')]
    public function index(CarRepository $repo): Response
    {
        $cars=$repo->findAll();
        // dd($car);
        return $this->render('car/index.html.twig', [
            'title' => 'All Car',
            'cars' => $cars,
        ]);
    }
    #[Route('/car/new/{userId}', name: 'car-create')]
    public function create(UserRepository $repoUser,Request $request, $userId,EntityManagerInterface $manager): Response
    {
       $user=new User();
       $user=$repoUser->findOneById($userId);
       $car= new Car();
       $car->setUser($user);
       $car->setCreatedAt(new \DateTimeImmutable);
       $form=$this->createFormBuilder($car)
                   ->add("mark")
                   ->add("dailyTariff") 
                   ->add("nbPlace") 
                   ->add("image") 
                   ->add("disponibility") 
                   ->add("color") 
                   ->getForm();

        $form->handleRequest($request);
        if( $form->isSubmitted() &&  $form->isValid()){
            //  dd($car);
            $manager->persist($car);
            $manager->flush(); 
           return $this->redirectToRoute("car-user-panel",["user"=>$user]);
        }
        return $this->render('car/create.html.twig', [
        'title' => 'New Car',
        'formCar'=> $form->createView(),
         ]);
    }
    #[Route('/car/edit/{id}', name: 'car-edit')]
    public function edit(CarRepository $repo,Request $request,$id,EntityManagerInterface $manager): Response
    {
        $car=new Car();
        $car=$repo->findOneById($id);
        // $car->setUser(($car).User);
        // $car->setMark(($car).mark);
        // $car->setDailyTariff(($car).dailyTariff);
        // $car->setNbPlace(($car).nbPlace);
        // $car->setImage(($car).image);
        // $car->setDisponibility(($car).disponibility);
        // $car->setColor(($car).color);
        $form=$this->createFormBuilder($car)
                   ->add("mark")
                   ->add("dailyTariff") 
                   ->add("nbPlace") 
                   ->add("image") 
                   ->add("disponibility") 
                   ->add("color") 
                   ->getForm();

        $form->handleRequest($request);
        if( $form->isSubmitted() &&  $form->isValid()){
            dd($car);
            $manager->persist($car);
            $manager->flush();
           return $this->redirectToRoute("car-user-panel",["user"=>$user]);
        }
         return $this->render('car/edit.html.twig', [
            'controller_name' => 'CarController',
         ]);
    }
    #[Route('/car/remove/{id}', name: 'car-remove')]
    public function remove(CarRepository $repo,$id): Response
    {
        $car=new Car();
        $car=$repo->remove($id);
         return $this->render('car/index.html.twig', [
            'controller_name' => 'CarController',
         ]);
    }
    
    // #[Route('/car/{id}', name: 'car-find')]
    // public function find($id): Response
    // {
    //     $car=$repo->find($id);
    //     dd($car);
    //     // return $this->render('car/index.html.twig', [
    //     // 'controller_name' => 'CarController',
    //     //  ]);
    // }
    
}
