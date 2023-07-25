<?php

namespace App\Entity;

use App\Repository\PersonneRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\MappedSuperclass;
use Symfony\Component\Validator\Constraints as Assert;

// #[ORM\Entity(repositoryClass: PersonneRepository::class)]
#[MappedSuperclass()]
class Personne
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    protected ?int $id;

    #[ORM\Column(length: 30)]
    protected ?string $nom = null;

    #[ORM\Column(length: 60)]
    protected ?string $prenoms = null;

    #[ORM\Column(length: 60)]
    //#[Assert\NotBlank(message: 'Veuillez entrer l\'adresse mail')]
    //#[Assert\Email(message: 'L\'adresse {{ value }} n\'est pas une adresse mail valide')]
    protected ?string $email = null;

    #[ORM\Column(length: 15)]
    protected ?string $tel = null;

    // #[ORM\OneToMany(mappedBy: 'proprietaire', targetEntity: TypePiece::class)]
    // protected Collection $piece;

    public function __construct()
    {
        //$this->piece = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenoms(): ?string
    {
        return $this->prenoms;
    }

    public function setPrenoms(string $prenoms): static
    {
        $this->prenoms = $prenoms;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getTel(): ?string
    {
        return $this->tel;
    }

    public function setTel(string $tel): static
    {
        $this->tel = $tel;

        return $this;
    }
}
