<?php

namespace App\Form;

use App\Entity\Livres;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LivresType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('isbn')
            ->add('titre_livre')
            ->add('theme_livre')
            ->add('nbr_pages_livre')
            ->add('format_livre')
            ->add('nom_auteur')
            ->add('prenom_auteur')
            ->add('editeur')
            ->add('prix_vente')
            ->add('langue_livre')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Livres::class,
        ]);
    }
}