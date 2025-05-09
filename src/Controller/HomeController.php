<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_front_index', methods: ['GET'])]
    public function index(): Response
    {
        $number = random_int(0, 100);
        return $this->render('index.html.twig', [
            'number' => $number,
        ]);
    }
}
