<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('gender', ChoiceType::class, [
                'choices'  => [
                    'Mr' => 'Mr',
                    'Mrs' => 'Mrs',
                ],
            ])
            ->add('firstname', TextType::class, array(
                'label' => 'Firstname ',
                'attr' => array(
                    'placeholder' => 'Enter firstname'
                )
            ))
            ->add('lastname', TextType::class, array(
            'label' => 'Lastname ',
            'attr' => array(
                'placeholder' => 'Enter lastname'
            )
            ))
            ->add('email', TextType::class, array(
                'label' => 'Email ',
                'attr' => array(
                    'placeholder' => 'Enter email'
                )
            ))
            ->add('password', PasswordType::class, array(
                'label' => 'Password ',
                'attr' => array(
                    'placeholder' => 'Enter password'
                )
            ))
            ->add('roles', ChoiceType::class, [
                'choices' => [
                    'Librarian' => "ROLE_LIBRARIAN"
                ],
                'expanded' => true,
                'multiple' => true,
                'label' => "Roles"
            ])
            ->add('agreeTerms', CheckboxType::class, [
                'mapped' => false,
                'constraints' => [
                    new IsTrue([
                        'message' => 'You should agree to our terms.',
                    ]),
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
