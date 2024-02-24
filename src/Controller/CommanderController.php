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
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use App\Form\DateSelectionType;



class CommanderController extends AbstractController
{

    //  ******************************************* TOUTES LES COMMANDES ******************************************************
    #[Route('/commandes', name: 'app_commandes', methods: ['GET'])]
    public function index(CommanderRepository $commanderRepository): Response
    {
        return $this->render('commander/index.html.twig', [
            'commandes' => $commanderRepository->findAllCommanderWithJointures(),
        ]);
    }

    //  *********************************************** AJOUT COMMANDE ********************************************


    #[Route('/commandes/ajout', name: 'ajout_commande', methods: ['GET', 'POST'])]
    public function ajout_commande(Request $request, EntityManagerInterface $entityManager,  CommanderRepository $commanderRepository): Response
    {

        $commande = new Commander();
        $form = $this->createForm(CommanderType::class, $commande);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($commande); // persist fait le lien entre l'ORM et symfony
            $entityManager->flush();              // flush fait le lien et applique les changements a la base de donnée
            return $this->redirectToRoute('app_commander', [], Response::HTTP_SEE_OTHER);  // Redirigez l'utilisateur vers une autre page, par exemple la liste des livres
        }

        return $this->render('commander/ajout_commande.html.twig', [
            'form' => $form->createView()
        ]);
    }

    // ****************************************************** MODIFICATION / UPDATE ******************************************

    #[Route('/commander/{id}/modif', name: 'form_commander_modif', methods: ['GET', 'POST'])]
    public function update(int $id, Request $request, CommanderRepository $commangerRepository, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(CommanderType::class, $commangerRepository->find($id));
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute(
                'app_commander',
                [],
                Response::HTTP_SEE_OTHER
            );
        }
        return $this->render('commander/update.html.twig', [
            'form' => $form, 'commande' => $commangerRepository->findAll(),
        ]);
    }


    // *********************************************************** SUPPRIMER *******************************************

    #[Route('/commander/{id}/supprimer', name: 'supprime_commande')]
    public function delete(int $id, EntityManagerInterface $entityManager,  CommanderRepository $commangerRepository): Response
    {
        $commande = $commangerRepository->find($id);

        $entityManager->remove($commande);

        $entityManager->flush();
        return $this->redirectToRoute('app_commander');
    }

    //  *********************************************************** COMMANDE PAR DATE ********************************

    #[Route('/pardate', name: 'commandes_par_date', methods: ['GET', 'POST'])]
    public function commande_date(Request $request, CommanderRepository $commanderRepository, EntityManagerInterface $entityManager): Response
    {
        // Récupérer toutes les commandes
        $commandes = $commanderRepository->findAll();

        $datesAchat = [];

        // Générer les options pour le formulaire de sélection de date
        foreach ($commandes as $commandedate) {
            $dateAchat = $commandedate->getDateAchat()->format('Y-m-d'); // Formatage de la date
            $datesAchat[$dateAchat] = $dateAchat; // Utilisation de la date comme clé et comme valeur
        }

        // Créer le formulaire de sélection de date
        $form = $this->createFormBuilder()
            ->add('date', ChoiceType::class, [
                'choices' => $datesAchat,
                'placeholder' => 'Choisir une date',
                'required' => false,
                'multiple' => false
            ])
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $dateChoisie = $form->get('date')->getData();
            $dateChoisie = new \DateTime($dateChoisie);
            $commandesDate = $commanderRepository->findBy(['Date_achat' => $dateChoisie]);

            // Afficher les commandes filtrées par la date choisie
            return $this->render('commander/index.html.twig', [
                'commandes' => $commandesDate,
            ]);
        }

        // Afficher le formulaire de sélection de date si non soumis ou invalide
        return $this->render('commander/dateCommande.html.twig', [
            'form' => $form->createView(),
        ]);
    }


    //******************************************** COMMANDE PAR EDITEUR ********************************************

    #[Route('/editeur', name: 'commande_par_editeur', methods: ['GET', 'POST'])]
    public function commande_editeur(Request $request, CommanderRepository $commanderRepository, EntityManagerInterface $entityManager): Response
    {
        $commande = $commanderRepository->findAllCommandesWithJointures(); // Récupérer tous les fournisseurs

        $form = $this->createFormBuilder()
            ->add('editeur', ChoiceType::class, [ //liste les éditeurs
                'choices' => $commande,
                'choice_label' => 'IdLivre.Editeur',
                'choice_value' => 'IdLivre.id',
                'placeholder' => 'Choisir un editeur',
                'required' => false,
                'multiple' => false

            ])

            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $editeurchoisis = $form->get('editeur')->getData();
            $editeurselect = $editeurchoisis->getIdLivre();

            return $this->render('commander/index.html.twig', [
                'commandes' => $commanderRepository->findBy(['Id_Livre' => $editeurselect]),

            ]);
        }

        return $this->render('commander/editeurCommande.html.twig', [
            'form' => $form->createView(),


        ]);
    }
}
