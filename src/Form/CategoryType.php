<?php

namespace App\Form;

use App\Entity\CatPortfolio;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class CategoryType extends ApplicationType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nameFr', TextType::class, $this->getConfiguration("Titre (fr)","Titre de la catégorie en français"))
            ->add('nameEn', TextType::class, $this->getConfiguration("Title (en)","Titre de la catégorie en anglais"))
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => CatPortfolio::class,
        ]);
    }
}
