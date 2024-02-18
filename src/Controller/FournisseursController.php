<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Fournisseurs;
use App\Form\FournisseurType;
use App\Repository\FournisseursRepository;
// use App\Form\FournisseurType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FournisseursController extends AbstractController
{
    // AFFICHAGE TOUT LES FOURNISSEURS *************************************************************************************************************************************


    #[Route('/fournisseurs', name: 'app_fournisseurs', methods: ['GET'])]
    public function index(FournisseursRepository $fournisseursRepository): Response
    {

        return $this->render('fournisseurs/index.html.twig', [
            'fournisseurs' => $fournisseursRepository->findAll(),

        ]);
    }


    // AFFICHAGE FORMULAIRE POUR MODFICATION ***************************************************************************************************************


    #[Route('/fournisseurs/{id}/update', name: 'form_fournisseurs', methods: ['GET', 'POST'])]
    public function update(int $id, Request $request, FournisseursRepository  $fournisseursRepository, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(FournisseurType::class, $fournisseursRepository->find($id));
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute(
                'app_fournisseurs',
                [],
                Response::HTTP_SEE_OTHER
            );
            
        }
        return $this->render('fournisseurs/update.html.twig', [
            'form' => $form, 'fournisseurs' => $fournisseursRepository->findAll(),

        ]);
    }

    // SUPPRIMER ***************************************************************************************************************


    #[Route('/fournisseurs/{id}/delete', name: 'delete_fournisseurs')]
    public function delete(int $id, EntityManagerInterface $entityManager,  FournisseursRepository $fournisseursRepository): Response
    {
        $fournisseurs = $fournisseursRepository->find($id);
        var_dump($fournisseurs);
        $entityManager->remove($fournisseurs);

        $entityManager->flush();
        return $this->redirectToRoute('app_fournisseurs');
    }

     // AJOUT ***************************************************************************************************************

     #[Route('/fournisseurs/create', name: 'create_fournisseurs', methods:['GET', 'POST'])]
     public function create_fournisseurs(Request $request, EntityManagerInterface $entityManager,  FournisseursRepository $fournisseursRepository ): Response
     {
 
         $fourniseurs = new Fournisseurs();
         $form = $this->createForm(FournisseurType::class, $fourniseurs);
         $form->handleRequest($request);
 
       if ($form->isSubmitted() && $form->isValid())
             {
             $entityManager->persist($fourniseurs); // persist fait le liens entre l'ORM et Symfony
             $entityManager->flush();              //flush fait le liens et applique les changements à la base de donnée
             return $this->redirectToRoute('app_fournisseurs', [], Response::HTTP_SEE_OTHER);  // Redirigez l'utilisateur vers une autre page, par exemple la liste des fournisseurs
             }
    
         return $this->render('fournisseurs/create.html.twig', [
             'form' => $form->createView()
         ]);
     }
    
}