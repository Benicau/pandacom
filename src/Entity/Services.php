<?php

namespace App\Entity;

use ApiPlatform\Metadata\Get;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;
use App\Repository\ServicesRepository;
use ApiPlatform\Metadata\GetCollection;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ServicesRepository::class)]
#[ApiResource(
    operations: [
        new Get(), 
        new GetCollection(),
    ]
)]
class Services
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message:"Le titre (fr) ne peut être vide")]
    #[Assert\Length(min:2,max:255, minMessage:"Le titre (fr) doit comprendre au minimum deux caractères",maxMessage:"Le titre (fr) ne peut dépasser les 255 caractères")]
    private ?string $titleFr = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message:"Le titre (en) ne peut être vide")]
    #[Assert\Length(min:2,max:255, minMessage:"Le titre (en) doit comprendre au minimum deux caractères",maxMessage:"Le titre (en) ne peut dépasser les 255 caractères")]
    private ?string $titleEn = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Assert\NotBlank(message:"La description (fr) ne peut être vide")]
    private ?string $description = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Assert\NotBlank(message:"La description (fr) ne peut être vide")]
    private ?string $descriptionEn = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message:"L'image' ne peut être vide")]
    #[Assert\Image(mimeTypes:["image/png","image/jpeg","image/jpg"], mimeTypesMessage:"Vous devez upload un fichier jpg, jpeg, png ou gif")]
    #[Assert\Image(maxSize:"2000000", maxSizeMessage:"Votre fichier dépasse le poid maximal autorisé")]
    private ?string $image = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitleFr(): ?string
    {
        return $this->titleFr;
    }

    public function setTitleFr(string $titleFr): self
    {
        $this->titleFr = $titleFr;

        return $this;
    }

    public function getTitleEn(): ?string
    {
        return $this->titleEn;
    }

    public function setTitleEn(string $titleEn): self
    {
        $this->titleEn = $titleEn;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getDescriptionEn(): ?string
    {
        return $this->descriptionEn;
    }

    public function setDescriptionEn(string $descriptionEn): self
    {
        $this->descriptionEn = $descriptionEn;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }
}
