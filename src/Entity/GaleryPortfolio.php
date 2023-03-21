<?php

namespace App\Entity;

use ApiPlatform\Metadata\Get;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GetCollection;
use App\Repository\GaleryPortfolioRepository;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: GaleryPortfolioRepository::class)]
#[ApiResource(
    normalizationContext: [
        'groups' => ['gallerie_read']
    ],
    operations: [
        new Get(), 
        new GetCollection(),
    ]
)]
class GaleryPortfolio
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\Image(mimeTypes:["image/png","image/jpeg","image/jpg"], mimeTypesMessage:"Vous devez upload un fichier jpg, jpeg, png ou gif")]
    #[Assert\Image(maxSize:"2000000", maxSizeMessage:"Votre fichier dépasse le poid maximal autorisé")]
    #[Assert\NotBlank(message: "Le fichier ne peut pas être vide")]
    private ?string $file = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "Le caption(fr) ne peut pas être vide")]
    #[Assert\Length(min:2,max:255, minMessage:"Le caption fr doit comprendre au minimum deux caractères",maxMessage:"Le caption fr ne peut dépasser les 255 caractères")]
    private ?string $captionFr = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "Le caption(en) ne peut pas être vide")]
    #[Assert\Length(min:2,max:255, minMessage:"Le caption (en) doit comprendre au minimum deux caractères",maxMessage:"Le caption (en) ne peut dépasser les 255 caractères")]
    private ?string $captionEn = null;

    #[ORM\ManyToOne(inversedBy: 'galeryImages')]
    private ?Portfolio $portfolio = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFile(): ?string
    {
        return $this->file;
    }

    public function setFile(string $file): self
    {
        $this->file = $file;

        return $this;
    }

    public function getCaptionFr(): ?string
    {
        return $this->captionFr;
    }

    public function setCaptionFr(string $captionFr): self
    {
        $this->captionFr = $captionFr;

        return $this;
    }

    public function getCaptionEn(): ?string
    {
        return $this->captionEn;
    }

    public function setCaptionEn(string $captionEn): self
    {
        $this->captionEn = $captionEn;

        return $this;
    }

    public function getPortfolio(): ?Portfolio
    {
        return $this->portfolio;
    }

    public function setPortfolio(?Portfolio $portfolio): self
    {
        $this->portfolio = $portfolio;

        return $this;
    }
}
