<?php

namespace App\Form;

use App\Entity\Pages;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class PageType extends ApplicationType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titleFr', TextType::class, $this->getConfiguration("Titre (fr)", "Titre de la page en français"))
            ->add('titleEn', TextType::class, $this->getConfiguration("Title (en)","Titre de la page en anglais"))
            ->add('textFr', CKEditorType::class, $this->getConfiguration('Texte (fr)',"Texte de contenu de page version française"))
            ->add('textEn', CKEditorType::class, $this->getConfiguration("Texte (en)","Texte de contenu de page version anglaise"))
            ->add('metaTittleFr', TextType::class, $this->getConfiguration("Meta titre (fr)", "Méta titre en français"))
            ->add('metaTittleEn', TextType::class, $this->getConfiguration("Meta titre (en)","Méta titre en anglais"))
            ->add('descriptionFr', TextareaType::class, $this->getConfiguration('Meta (fr)',"Meta de page version française"))
            ->add('descriptionEn', TextareaType::class, $this->getConfiguration("Meta (en)","Meta de page version anglaise"))
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Pages::class,
        ]);
    }
}
