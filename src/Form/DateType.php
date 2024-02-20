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

class DateCommandeType extends AbstractType
{

    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }


    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('DateAchat', ChoiceType::class, [
                'label' => 'Date dachat',
                'choices' => $this->getDateAchat(),
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Livres::class,
        ]);
    }

    private function getDateAchat()
    {


        // Exemple : exécuter une requête SQL
        $query = $this->entityManager->createQuery('SELECT commander FROM App\Entity\Commander commander GROUP BY commander.DateAchat');
        $commander = $query->getResult();


        $commander = [];
        foreach ($commander as $commande) {

            $editeur[$commande->getDateAchat()] = $commande->getEditeur();
        }
        return $editeur;
    }
}