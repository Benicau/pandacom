<?php

namespace App\Entity;

use ApiPlatform\Metadata\Get;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\PagesRepository;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GetCollection;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: PagesRepository::class)]
#[ApiResource(
    operations: [
        new Get(), 
        new GetCollection(),
    ]
)]
class Pages
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

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $textFr = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $metaTittleEn = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $metaTittleFr = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $textEn = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message:"La description ne peut être vide")]
    #[Assert\Length(min:2,max:160, minMessage:"La description (fr) doit comprendre au minimum deux caractères",maxMessage:"La description (fr) ne peut dépasser les 160 caractères")]
    private ?string $descriptionFr = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message:"La description ne peut être vide")]
    #[Assert\Length(min:2,max:160, minMessage:"La description (en) doit comprendre au minimum deux caractères",maxMessage:"La description (en) ne peut dépasser les 160 caractères")]
    private ?string $descriptionEn = null;


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

    public function getTextFr(): ?string
    {
        return $this->textFr;
    }

    public function setTextFr(?string $textFr): self
    {
        $this->textFr = $textFr;

        return $this;
    }

    public function getMetaTittleEn(): ?string
    {
        return $this->metaTittleEn;
    }

    public function setMetaTittleEn(?string $metaTittleEn): self
    {
        $this->metaTittleEn = $metaTittleEn;

        return $this;
    }

    public function getMetaTittleFr(): ?string
    {
        return $this->metaTittleFr;
    }

    public function setMetaTittleFr(?string $metaTittleFr): self
    {
        $this->metaTittleFr = $metaTittleFr;

        return $this;
    }

    public function getTextEn(): ?string
    {
        return $this->textEn;
    }

    public function setTextEn(?string $textEn): self
    {
        $this->textEn = $textEn;

        return $this;
    }

    public function getDescriptionFr(): ?string
    {
        return $this->descriptionFr;
    }

    public function setDescriptionFr(string $descriptionFr): self
    {
        $this->descriptionFr = $descriptionFr;

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
    
}
