<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\CommanderRepository;
use App\Entity\Commander;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Form\CommanderType;
use App\Form\Commander\SocialeType;
// use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class CommanderController extends AbstractController
{
    #[Route('/commandes', name: 'app_commandes',methods:['GET'])]
    public function index(CommanderRepository $commanderRepository): Response
    {
        return $this->render('commander/index.html.twig', [
            'commandes' =>$commanderRepository->findAllCommanderWithJointures(),
        ]);
    }
}