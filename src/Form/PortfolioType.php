<?php

namespace App\Form;

use App\Entity\Portfolio;
use App\Form\ApplicationType;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use FOS\CKEditorBundle\Form\Type\CKEditorType;


class PortfolioType extends ApplicationType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titleFr',TextType::class, $this->getConfiguration("Titre (fr)","Titre du projet en français"))
            ->add('titleEn', TextType::class, $this->getConfiguration("Title (En)","Titre du projet en anglais"))
            ->add('descriptionFr',CKEditorType::class, $this->getConfiguration("Description du projet (fr)","Description du projet en français"))
            ->add('descriptionEn',CKEditorType::class, $this->getConfiguration("Description du projet (En)","Description du projet en anglais"))
            ->add('link', TextType::class, $this->getConfiguration("Lien", "Lien vers le site internet du projet"))
            ->add('coverImage', FileType::class, [
                "label"=>"Image de couverture du projet (obligatoire)",
                "data_class"=>null
            ])
            ->add('slug', TextType::class, $this->getConfiguration("Slug","Slug du projet"))
            ->add(
                'galeryImages',
                FileType::class,
                [
                    'label'=>"Images de la galerie",
                    "multiple"=>true,
                    "mapped"=>false,
                    "required"=>true,
                    'attr'=>['class'=>'form-control']
                ]
            )
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Portfolio::class,
        ]);
    }
}
