<?php

namespace App\Entity;

use Cocur\Slugify\Slugify;
use ApiPlatform\Metadata\Get;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GetCollection;
use App\Repository\PortfolioRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\HasLifecycleCallbacks]
#[ORM\Entity(repositoryClass: PortfolioRepository::class)]
#[ApiResource(
    normalizationContext: [
        'groups' => ['portfolio_read']
    ],
    operations: [
        new Get(), 
        new GetCollection(),
    ]
)]
class Portfolio
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
    private ?string $descriptionFr = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Assert\NotBlank(message:"La description (en) ne peut être vide")]
    private ?string $descriptionEn = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $link = null;

    #[ORM\Column(length: 255)]
    #[Assert\Image(mimeTypes:["image/png","image/jpeg","image/jpg"], mimeTypesMessage:"Vous devez upload un fichier jpg, jpeg, png ou gif")]
    #[Assert\Image(maxSize:"2000000", maxSizeMessage:"Votre fichier dépasse le poid maximal autorisé")]
    #[Assert\NotBlank(message:"L'image de couverture ne peut être vide")]
    private ?string $coverImage = null;

    #[ORM\OneToMany(mappedBy: 'portfolio', targetEntity: GaleryPortfolio::class, orphanRemoval:true, cascade:['persist'])]
    private Collection $galeryImages;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message:"Le slug ne peut être vide")]
    #[Assert\Length(min:2,max:255, minMessage:"Le slug doit comprendre au minimum deux caractères",maxMessage:"Le slug ne peut dépasser les 255 caractères")]
    private ?string $slug = null;

    #[ORM\ManyToMany(targetEntity: CatPortfolio::class, inversedBy: 'portfolios')]
    #[Assert\NotBlank(message:"La catégorie ne peut être vide")]
    private Collection $Category;

    #[ORM\Column]
    #[Assert\NotBlank(message:"La date ne peut être vide")]
    private ?\DateTimeImmutable $CreatedAt = null;
    

    public function __construct()
    {
        
        $this->galeryImages = new ArrayCollection();
        $this->Category = new ArrayCollection();
        $this->CreatedAt = new \DateTimeImmutable();
    }

    /**
     * Auto initialise slug of project
     *
     * @return void
     */
    #[ORM\PrePersist]
    #[ORM\PreUpdate]
    public function initializeSlug():void{
        if (empty($this->slug)){
            $slugify = new Slugify();
            $this->slug = $slugify->slugify($this->titleFr.'-'.rand());
        }
    }

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

    public function getLink(): ?string
    {
        return $this->link;
    }

    public function setLink(?string $link): self
    {
        $this->link = $link;

        return $this;
    }

    public function getCoverImage(): ?string
    {
        return $this->coverImage;
    }

    public function setCoverImage(string $coverImage): self
    {
        $this->coverImage = $coverImage;

        return $this;
    }

    /**
     * @return Collection<int, GaleryPortfolio>
     */
    public function getGaleryImages(): Collection
    {
        return $this->galeryImages;
    }

    public function addGaleryImage(GaleryPortfolio $galeryImage): self
    {
        if (!$this->galeryImages->contains($galeryImage)) {
            $this->galeryImages->add($galeryImage);
            $galeryImage->setPortfolio($this);
        }

        return $this;
    }

    public function removeGaleryImage(GaleryPortfolio $galeryImage): self
    {
        if ($this->galeryImages->removeElement($galeryImage)) {
            // set the owning side to null (unless already changed)
            if ($galeryImage->getPortfolio() === $this) {
                $galeryImage->setPortfolio(null);
            }
        }

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * @return Collection<int, CatPortfolio>
     */
    public function getCategory(): Collection
    {
        return $this->Category;
    }

    public function addCategory(CatPortfolio $category): self
    {
        if (!$this->Category->contains($category)) {
            $this->Category->add($category);
        }

        return $this;
    }

    public function removeCategory(CatPortfolio $category): self
    {
        $this->Category->removeElement($category);

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->CreatedAt;
    }

    public function setCreatedAt(\DateTimeImmutable $CreatedAt): self
    {
        $this->CreatedAt = $CreatedAt;

        return $this;
    }
}
