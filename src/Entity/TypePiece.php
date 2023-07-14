<?php

namespace App\Entity;

use App\Repository\TypePieceRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TypePieceRepository::class)]
class TypePiece
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 15)]
    private ?string $NumPiece = null;

    #[ORM\Column(length: 60, nullable: true)]
    private ?string $NomPiece = null;

    #[ORM\ManyToOne(inversedBy: 'piece')]
    private ?Personne $proprietaire = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumPiece(): ?string
    {
        return $this->NumPiece;
    }

    public function setNumPiece(string $NumPiece): static
    {
        $this->NumPiece = $NumPiece;

        return $this;
    }

    public function getNomPiece(): ?string
    {
        return $this->NomPiece;
    }

    public function setNomPiece(?string $NomPiece): static
    {
        $this->NomPiece = $NomPiece;

        return $this;
    }

    public function getProprietaire(): ?Personne
    {
        return $this->proprietaire;
    }

    public function setProprietaire(?Personne $proprietaire): static
    {
        $this->proprietaire = $proprietaire;

        return $this;
    }
}
