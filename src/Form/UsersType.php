<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UsersType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('field_name')
            ->add('field_name')
            ->add('field_name')
            ->add('field_name')
            ->add('field_name')
            ->add('field_name')
            ->add('field_name')
        ;
    }

   
}
