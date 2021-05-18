<?php

namespace App\Form;

use App\Entity\Book;
use App\Entity\Genre;
use App\Entity\Type;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BookType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('summary')
            ->add('quantity')
            ->add('published_date')
            ->add('genre_id', EntityType::class, [
                'class' => Genre::class, //Permet de récupérer le nom de la classe
                'choice_label' => 'name' //On récupére le nom du genre
            ])
            ->add('type_id', EntityType::class, [
                'class' => Type::class, //Permet de récupérer le nom de la classe
                'choice_label' => 'name' //On récupére le nom du type
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Book::class,
        ]);
    }
}
