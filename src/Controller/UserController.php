<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\UserRepository;
use App\Repository\CarRepository;
use App\Entity\User;

class UserController extends AbstractController
{
    #[Route('/user/new', name: 'user-create')]
    public function create(UserRepository $repo,Request $request): Response
    {
        //sign up
        $user=new User();
        $form=$this->createFormBuilder($user)
                    ->add("email")
                   ->add("userName")
                   ->add("firstName")
                   ->add("userGender",)
                   ->add("userPhone") 
                   ->add("userCity") 
                   ->add("userProvince") 
                   ->add("userCategory") 
                   ->add("password",PasswordType::class) 
                   ->add("confirm_password",PasswordType::class) 
                   ->getForm();

                   $form->handleRequest($request);
                   if( $form->isSubmitted() &&  $form->isValid()){
                     // $hash=$encoder->encodePassword($user,$user->getPassword());
                     // $user->setPassword($hash);
                     //if($user->getPlainPassword()){
                        
                        dd($user);
                         //   $manager->persist($)user;
                     //   $manager->flush();
                       
                      // return $this->redirectToRoute("",[""=>""]);

                     //}
                      
                   }

         return $this->render('user/signUp.html.twig', [
            'title' => 'new user',
            'formUser'=> $form->createView(),
         ]);
    }
    #[Route('/user/:id/dashboard', name: 'dashboard-user-panel')]
    public function UserPanelDashboard(): Response
    {
       //Dashboard
       return $this->render('userPanel/dashboard.html.twig', [
        'title' => 'User Dashboard ',
          ]);

    }
    #[Route('/user/car/:user', name: 'car-user-panel')]
    public function UserPanelCar(CarRepository $repo,$user): Response
    {
       //Car
       $cars=$repo->findByUser($user);
       return $this->render('userPanel/mycar.html.twig', [
       'title' => 'My car',
       'cars' => $cars,
        'user'=>$user,
         ]);
    }
    #[Route('/user/{id}', name: 'index-user-panel')]
    public function UserPanelIndex(UserRepository $repo,$id): Response
    {
       //PROFIL
       $user=$repo->find($id);
       return $this->render('userPanel/index.html.twig', [
       'title' => 'My car',
       'user' => $user,
         ]);

    }
    
    /****favorite, transaction, listenoire,recherche ...******/
}
