<?php

namespace App\Form;

use App\Entity\Fournisseurs;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use App\Repository\LivreRepository;
use Doctrine\ORM\EntityManagerInterface;

class LocaliteType extends AbstractType
{

    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }


    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('Localite', ChoiceType::class, [
                'label' => 'Localite',
                'choices' => $this->getLocalite(),
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Fournisseurs::class,
        ]);
    }

    private function getLocalite()
    {


        // Exemple : exécuter une requête DQL
        $query = $this->entityManager->createQuery('SELECT f.Localite FROM App\Entity\Fournisseurs f GROUP BY f.Localite');
        $fournisseurs = $query->getResult();

        $Localite = [];
        foreach ($fournisseurs as $fournisseur) {
            // La requête DQL retourne un tableau de tableaux avec 'Raison_sociale' comme clé
            $raison = $fournisseur['Localite']; // Accès à la Raison_sociale
            $Localite[$raison] = $raison; // Clé et valeur sont la Raison_socialenSociale[$fournisseur->getRaisonSociale()] = $fournisseurs->getRaisonSociale();
        }
        return $Localite;
    }
}