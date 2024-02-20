<?php

namespace App\Form;


use App\Entity\Livres;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use App\Repository\LivreRepository;
use Doctrine\ORM\EntityManagerInterface;

class AuteurLivreType extends AbstractType
{

    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }


    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nomauteur', ChoiceType::class, [
                'label' => 'Auteur du livre',
                'choices' => $this->getnomauteur(),
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Livres::class,
        ]);
    }

    private function getnomauteur()
    {


        // Exemple : exécuter une requête SQL
        $query = $this->entityManager->createQuery('SELECT livres FROM App\Entity\Livres livres GROUP BY livres.nomauteur');
        $livres = $query->getResult();


        $nomauteur = [];
        foreach ($livres as $livre) {

            $nomauteur[$livre->getnomauteur()] = $livre->getnomauteur();
        }
        return $nomauteur;
    }
}