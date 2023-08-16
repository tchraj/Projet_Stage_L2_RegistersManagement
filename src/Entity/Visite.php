<?php

namespace App\Entity;

use App\Entity\VisiteurExterne;
use App\Repository\VisiteRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\EntityManagerInterface;

#[ORM\Entity(repositoryClass: VisiteRepository::class)]
class Visite
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: false)]
    private ?\DateTimeInterface $DateVisite;

    #[ORM\Column(type: Types::TIME_MUTABLE, nullable: false)]
    private ?\DateTimeInterface $HeureDeb;

    #[ORM\Column(type: Types::TIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $HeureFin;

    #[ORM\Column(type: Types::TEXT, nullable: false)]
    private ?string $motif;

    #[ORM\Column]
    private ?string $EtatVisite;

    // #[ORM\Column(type: Types::TEXT)]
    // private ?string $nomVisiteur;

    #[ORM\ManyToOne(inversedBy: 'visites')]
    private ?VisiteurExterne $visiteurExterne = null;

    #[ORM\ManyToOne(inversedBy: 'Visiteeffectuee', cascade: ["persist"])]
    private ?Employe $EmployeVisiteur = null;

    #[ORM\ManyToOne(inversedBy: 'VisiteRecue')]
    private ?Employe $EmployeVisite = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    #[ORM\Column(type: Types::TEXT, nullable: false)]
    private ?string $typeVisiteur;

    #[ORM\Column(length: 60, nullable: true)]
    private ?string $typePiece = null;

    #[ORM\Column(length: 15)]
    private ?string $NumPiece = null;

    public function getTypeVisiteur(): ?string
    {
        return $this->typeVisiteur;
    }
    // public function getNomVisiteur()
    // {
    //     return $this->nomVisiteur;
    // }
    // public function setNomVisiteur(?string $nomVisiteur): static
    // {
    //     $this->nomVisiteur = $nomVisiteur;
    //     return $this;
    // }
    public function setTypeVisiteur(string $typeVisiteur): static
    {
        $this->typeVisiteur = $typeVisiteur;

        return $this;
    }

    public function getDateVisite(): ?\DateTimeInterface
    {
        return $this->DateVisite;
    }

    public function setDateVisite(\DateTimeInterface $DateVisite): static
    {
        $this->DateVisite = $DateVisite;

        return $this;
    }


    public function getHeureDeb(): ?\DateTimeInterface
    {
        return $this->HeureDeb;
    }

    public function setHeureDeb(\DateTimeInterface $HeureDeb): static
    {
        $this->HeureDeb = $HeureDeb;

        return $this;
    }

    public function getHeureFin(): ?\DateTimeInterface
    {
        return $this->HeureFin;
    }

    public function setHeureFin(\DateTimeInterface $HeureFin): static
    {
        $this->HeureFin = $HeureFin;

        return $this;
    }

    public function getMotif(): ?string
    {
        return $this->motif;
    }

    public function setMotif(string $motif): static
    {
        $this->motif = $motif;

        return $this;
    }

    public function getEtatVisite(): ?string
    {
        return $this->EtatVisite;
    }

    public function setEtatVisite(string $EtatVisite): static
    {
        $this->EtatVisite = $EtatVisite;

        return $this;
    }

    public function getVisiteurExterne(): ?VisiteurExterne
    {
        return $this->visiteurExterne;
    }

    public function setVisiteurExterne(?VisiteurExterne $visiteurExterne): static
    {
        $this->visiteurExterne = $visiteurExterne;
        return $this;
    }

    public function getEmployeVisiteur(): ?Employe
    {
        return $this->EmployeVisiteur;
    }

    public function setEmployeVisiteur(?Employe $employe): static
    {
        $this->EmployeVisiteur = $employe;

        return $this;
    }

    public function getEmployeVisite(): ?Employe
    {
        return $this->EmployeVisite;
    }

    public function setEmployeVisite(?Employe $EmployeVisite): static
    {
        $this->EmployeVisite = $EmployeVisite;

        return $this;
    }

    public function setDefaultVisiteur($visiteurId, EntityManagerInterface $entityManager)
    {
        $visiteurExterne = $entityManager->getRepository(VisiteurExterne::class)->find($visiteurId);
        if ($visiteurExterne) {
            $this->visiteurExterne = $visiteurExterne;
        }
    }

    public function getTypePiece(): ?string
    {
        return $this->typePiece;
    }

    public function setTypePiece(?string $typePiece): static
    {
        $this->typePiece = $typePiece;

        return $this;
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
}
