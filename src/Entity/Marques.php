<?php

namespace App\Entity;

use ApiPlatform\Metadata\Get;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;
use App\Repository\MarquesRepository;
use ApiPlatform\Metadata\GetCollection;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: MarquesRepository::class)]
#[ApiResource(
    operations: [
        new Get(), 
        new GetCollection(),
    ]
)]
class Marques
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\Length(min:2,max:255, minMessage:"Le nom de marque doit comprendre au minimum deux caractères",maxMessage:"Le nom de marque ne peut dépasser les 255 caractères")]
    #[Assert\NotBlank(message:"Le nom de marque ne peut être vide")]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    #[Assert\Image(mimeTypes:["image/png","image/jpeg","image/jpg"], mimeTypesMessage:"Vous devez upload un fichier jpg, jpeg, png ou gif")]
    #[Assert\Image(maxSize:"2000000", maxSizeMessage:"Votre fichier dépasse le poid maximal autorisé")]
    #[Assert\NotBlank(message:"Le logo de marque ne peut être vide")]
    private ?string $images = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getImages(): ?string
    {
        return $this->images;
    }

    public function setImages(string $images): self
    {
        $this->images = $images;

        return $this;
    }
}
