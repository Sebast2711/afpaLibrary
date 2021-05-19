<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email')
            ->add('roles', ChoiceType::class, [
                'choices' => [
                    'Utilisateur' => "ROLE_USER",
                    'Administrateur' => "ROLE_ADMIN",
                    'Bibliothecaire' => "ROLE_BIBLIO"
                ],
                'expanded' => true,
                'multiple' => true,
                'label' => "Roles"
            ])
            ->add('password', PasswordType::class)
            ->add('firstname')
            ->add('lastname')
            ->add('gender', ChoiceType::class, [
                'choices' => [
                    'Mister' => 'Mr',
                    'Madam' => 'Mrs'
                ],
                'expanded' => true,
                'multiple' => true,
                'label' => 'Roles'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
