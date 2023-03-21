<?php

namespace App\Form;

use App\Entity\GaleryPortfolio;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class ImageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('file', FileType::class, [
                'attr'=>[
                    'placeholder'=>"Fichier"
                ]
            ])
            ->add('captionFr', TextType::class, [
                'attr'=>[
                    'placeholder'=>"Titre de l'image"
                ]
            ])
            ->add('captionEn', TextType::class, [
                'attr'=>[
                    'placeholder'=>"Titre de l'image"
                ]
            ])
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => GaleryPortfolio::class,
        ]);
    }
}
