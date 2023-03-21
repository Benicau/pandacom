<?php

namespace App\Form;

use App\Entity\Team;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TeamType extends ApplicationType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, $this->getConfiguration('Nom', "Nom du membre"))
            ->add('firstname', TextType::class, $this->getConfiguration("Prénom", "Prénom du membre"))
            ->add('rolesFr', TextType::class, $this->getConfiguration("Rôles (fr)","Roles du membre en français"))
            ->add('rolesEn', TextType::class, $this->getConfiguration("Roles (en)","Rôles en anglais"))
            ->add('image', FileType::class, [
                "label"=>"Photo",
                "data_class"=> null,
                "required"=>false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Team::class,
        ]);
    }
}
