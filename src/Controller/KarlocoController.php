<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\CarRepository;

class KarlocoController extends AbstractController
{
    #[Route('/', name: 'karloco-home')]
    public function index(CarRepository $repo): Response
    {
        $cars=$repo->findLastCar(5);
                 
        return $this->render('index.html.twig', [
            'cars'=> $cars,
            'title'=> 'Home',
        ]);
    }
}
