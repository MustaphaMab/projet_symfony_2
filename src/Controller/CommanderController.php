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

    //  ******************************************* TOUTES LES COMMANDES ******************************************************
    #[Route('/commandes', name: 'app_commandes',methods:['GET'])]
    public function index(CommanderRepository $commanderRepository): Response
    {
        return $this->render('commander/index.html.twig', [
            'commandes' =>$commanderRepository->findAllCommanderWithJointures(),
        ]);
    }

    //  *********************************************** AJOUT COMMANDE ********************************************


    #[Route('/commandes/ajout', name: 'ajout_commande', methods:['GET', 'POST'])]
    public function ajout_commande(Request $request, EntityManagerInterface $entityManager,  CommanderRepository $commanderRepository ): Response
    {
        
        $commande = new Commander();
        $form = $this->createForm(CommanderType::class, $commande);
        $form->handleRequest($request);

      if ($form->isSubmitted() && $form->isValid())
            {  
            $entityManager->persist($commande); // persist fait le lien entre l'ORM et symfony
            $entityManager->flush();              // flush fait le lien et applique les changements a la base de donnée
            return $this->redirectToRoute('app_commander', [], Response::HTTP_SEE_OTHER);  // Redirigez l'utilisateur vers une autre page, par exemple la liste des livres
            }

        return $this->render('commander/ajout_commande.html.twig', [
            'form' => $form->createView()
        ]);
    }
}