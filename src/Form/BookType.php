<?php

namespace App\Form;

use App\Entity\Books;
use App\Form\ImageType;
use App\Form\KeywordType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;


class BookType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title',TextType::class,['label'=>'Titre','attr'=>['placeholder'=>'Titre du livre','required'=>false]])
            ->add('author',TextType::class,['label'=>'Auteur','attr'=>['placeholder'=>'Le nom de l\'auteur','required'=>false]])
            ->add('price',IntegerType::class,['label'=>'Prix','attr'=>['placeholder'=>'Le prix du livre','required'=>false]])
            
            ->add('image',ImageType::class,['label'=>false])
            ->add('keywords',CollectionType::class,[
                'entry_type'=>KeywordType::class,
                'allow_add'=> true,
                'by_reference' => false
            ])
           
            ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Books::class,
        ]);
    }
}
