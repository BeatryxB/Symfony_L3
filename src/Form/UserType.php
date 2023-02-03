<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', null,  ['label' => 'Nom', 'required'=>true])
            ->add('prenom', null,  ['label' => 'Prenom', 'required'=>true])
            ->add('genre', null,  ['label' => 'Genre', 'required'=>true])
            ->add('dateNaissance', DateType::class,  ['label' => 'Date de naissance', 'required'=>true])
            ->add('telephone', TelType::class,  ['label' => 'Telephone'])
            ->add('ville', null,  ['label' => 'Ville'])
            ->add('codePostal', null,  ['label' => 'Code Postal'])
            ->add('pays', null,  ['label' => 'Pays'])
            ->add('numSecu', null,  ['label' => 'Numero de sécurité sociale'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
