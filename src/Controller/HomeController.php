<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    /* #[Route('/', name: 'app_front_index', methods: ['GET'])]
    public function index(): Response
    {
        return $this->render('index.html.twig', [
            'controller_name' => 'HomeController',
            'title' => 'Actualité'
        ]);
    }*/
    #[Route('/', name: 'app_front_index', methods: ['GET'])]
    public function index(): Response
    {
        $number = random_int(0, 100);
        return $this->render('index.html.twig', [
            'number' => $number,
        ]);
        return $this->render('index.html.twig', [
            'controller_name' => 'HomeController',
            'title' => 'rien',
        ]);
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/DashboardController.php',
        ]);
    }
}
