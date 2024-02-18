<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Livres;
use Symfony\Component\HttpFoundation\Request;
use App\Form\LivresType;
use App\Repository\LivresRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LivresController extends AbstractController
{

    // AFFICHAGE TOUT LES FOURNISSEURS *************************************************************************************************************************************

    #[Route('/livres', name: 'app_livres', methods: ['GET'])]
    public function index(LivresRepository $livresRepository): Response
    {


        return $this->render('livres/index.html.twig', [
            'livres' => $livresRepository->findAll(),

        ]);
    }

    // AFFICHAGE FORMULAIRE POUR MODFICATION ***************************************************************************************************************

    #[Route('/livres{id}/update', name: 'form_Livres', methods: ['GET', 'POST'])]
    public function update(int $id, Request $request, LivresRepository  $livresRepository, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(LivresType::class, $livresRepository->find($id));
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute(
                'app_livres',
                [],
                Response::HTTP_SEE_OTHER
            );
        }
        return $this->render('livres/update.html.twig', [
            'form' => $form, 'livre' => $livresRepository->findAll(),

        ]);
    }


    // SUPPRIMER ***************************************************************************************************************


    #[Route('/livres/{id}/delete', name: 'delete_livres')]
    public function delete(int $id, EntityManagerInterface $entityManager,  LivresRepository $livresRepository): Response
    {
        $livre = $livresRepository->find($id);
        var_dump($livre);
        $entityManager->remove($livre);

        $entityManager->flush();
        return $this->redirectToRoute('app_livres');
    }

    // AJOUT ***************************************************************************************************************

    #[Route('/livres/create', name: 'create_livre', methods:['GET', 'POST'])]
    public function create_livre(Request $request, EntityManagerInterface $entityManager,  LivresRepository $livresRepository ): Response
    {

        $livre = new Livres();
        $form = $this->createForm(LivresType::class, $livre);
        $form->handleRequest($request);

      if ($form->isSubmitted() && $form->isValid())
            {
            $entityManager->persist($livre); // persist fait le liens entre l'ORM et Symfony
            $entityManager->flush();              //flush fait le liens et applique les changements à la base de donnée
            return $this->redirectToRoute('app_livres', [], Response::HTTP_SEE_OTHER);  // Redirigez l'utilisateur vers une autre page, par exemple la liste des livres
            }
   
        return $this->render('livres/create.html.twig', [
            'form' => $form->createView()
        ]);
    }
    
}