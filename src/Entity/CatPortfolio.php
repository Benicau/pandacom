<?php

namespace App\Entity;

use ApiPlatform\Metadata\Get;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GetCollection;
use App\Repository\CatPortfolioRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: CatPortfolioRepository::class)]
#[ApiResource(
    normalizationContext: [
        'groups' => ['category_read']
    ],
    operations: [
        new Get(), 
        new GetCollection(),
    ]
)]
class CatPortfolio
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\Length(min:2, max:255, minMessage:"Le nom de catégorie doit au moins dépasser les 2 caractères", maxMessage:"Le nom de la catégorie ne peut dépasser les 255 caractères")]
    #[Assert\NotBlank(message: "Le nom de la catégorie(fr) ne peut pas être vide")]
    private ?string $nameFr = null;

    #[ORM\Column(length: 255)]
    #[Assert\Length(min:2, max:255, minMessage:"Le nom de catégorie doit au moins dépasser les 2 caractères", maxMessage:"Le nom de la catégorie ne peut dépasser les 255 caractères")]
    #[Assert\NotBlank(message: "Le nom de la catégorie(en) ne peut pas être vide")]
    private ?string $nameEn = null;

    #[ORM\ManyToMany(targetEntity: Portfolio::class, mappedBy: 'Category')]
    private Collection $portfolios;

    public function __construct()
    {
        $this->portfolios = new ArrayCollection();
    }

   

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNameFr(): ?string
    {
        return $this->nameFr;
    }

    public function setNameFr(string $nameFr): self
    {
        $this->nameFr = $nameFr;

        return $this;
    }

    public function getNameEn(): ?string
    {
        return $this->nameEn;
    }

    public function setNameEn(string $nameEn): self
    {
        $this->nameEn = $nameEn;

        return $this;
    }

    /**
     * @return Collection<int, Portfolio>
     */
    public function getPortfolios(): Collection
    {
        return $this->portfolios;
    }

    public function addPortfolio(Portfolio $portfolio): self
    {
        if (!$this->portfolios->contains($portfolio)) {
            $this->portfolios->add($portfolio);
            $portfolio->addCategory($this);
        }

        return $this;
    }

    public function removePortfolio(Portfolio $portfolio): self
    {
        if ($this->portfolios->removeElement($portfolio)) {
            $portfolio->removeCategory($this);
        }

        return $this;
    }
}
