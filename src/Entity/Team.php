<?php

namespace App\Entity;

use ApiPlatform\Metadata\Get;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\TeamRepository;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GetCollection;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: TeamRepository::class)]
#[ApiResource(
    operations: [
        new Get(), 
        new GetCollection(),
    ]
)]
class Team
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message:"Le nom ne peut être vide")]
    #[Assert\Length(min:2,max:255, minMessage:"Le nom doit comprendre au minimum deux caractères",maxMessage:"Le nom ne peut dépasser les 255 caractères")]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message:"Le prénom ne peut être vide")]
    #[Assert\Length(min:2,max:255, minMessage:"Le prénom doit comprendre au minimum deux caractères",maxMessage:"Le prénom ne peut dépasser les 255 caractères")]
    private ?string $firstname = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message:"Le champ rôles (fr) ne peut être vide")]
    #[Assert\Length(min:2,max:255, minMessage:"Le rôle (fr) doit comprendre au minimum deux caractères",maxMessage:"Le rôle (fr) ne peut dépasser les 255 caractères")]
    private ?string $rolesFr = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message:"Le champ rôles (en) ne peut être vide")]
    #[Assert\Length(min:2,max:255, minMessage:"Le rôle (en) doit comprendre au minimum deux caractères",maxMessage:"Le rôle (fr) ne peut dépasser les 255 caractères")]
    private ?string $rolesEn = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\Image(mimeTypes:["image/png","image/jpeg","image/jpg"], mimeTypesMessage:"Vous devez upload un fichier jpg, jpeg, png ou gif")]
    #[Assert\Image(maxSize:"2000000", maxSizeMessage:"Votre fichier dépasse le poid maximal autorisé")]
    private ?string $image = null;

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

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getRolesFr(): ?string
    {
        return $this->rolesFr;
    }

    public function setRolesFr(string $rolesFr): self
    {
        $this->rolesFr = $rolesFr;

        return $this;
    }

    public function getRolesEn(): ?string
    {
        return $this->rolesEn;
    }

    public function setRolesEn(string $rolesEn): self
    {
        $this->rolesEn = $rolesEn;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;

        return $this;
    }
}
