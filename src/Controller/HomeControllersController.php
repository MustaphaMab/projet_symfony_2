<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeControllersController extends AbstractController
{
    #[Route('/home/controllers', name: 'app_home_controllers')]
    public function index(): Response
    {
        return $this->render('home_controllers/index.html.twig', [
            'controller_name' => 'HomeControllersController',
        ]);
    }
}
