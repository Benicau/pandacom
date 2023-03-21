<?php

namespace App\Form;

use App\Entity\Services;
use Symfony\Component\Form\AbstractType;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ServiceType extends ApplicationType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titleFr', TextType::class, $this->getConfiguration("Titre (fr)", "Titre du service en français"))
            ->add('titleEn', TextType::class, $this->getConfiguration("Titre (En)","Titre du service en anglais"))
            ->add('description', CKEditorType::class, $this->getConfiguration("Description (fr)","Description du service en français"))
            ->add('descriptionEn', CKEditorType::class, $this->getConfiguration("Description (En)","Description du service en anglais"))
            ->add('image', FileType::class, [
                "label"=>"Image du service (obligatoire)",
                "data_class"=>null
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Services::class,
        ]);
    }
}
