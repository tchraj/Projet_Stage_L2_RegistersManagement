<?php

namespace App\Entity;

use App\Repository\VisiteRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: VisiteRepository::class)]
class Visite
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $DateVisite = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    private ?\DateTimeInterface $HeureDeb = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    private ?\DateTimeInterface $HeureFin = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $motif = null;

    #[ORM\Column]
    private ?bool $EtatVisite = null;

    #[ORM\ManyToOne(inversedBy: 'visites')]
    private ?VisiteurExterne $visiteurExterne = null;

    #[ORM\ManyToOne(inversedBy: 'Visiteeffectuee')]
    private ?Employe $EmployeVisiteur = null;

    #[ORM\ManyToOne(inversedBy: 'VisiteRecue')]
    private ?Employe $EmployeVisite = null;

    public function getId(): ?int
    {
        return $this->id;
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

    public function isEtatVisite(): ?bool
    {
        return $this->EtatVisite;
    }

    public function setEtatVisite(bool $EtatVisite): static
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

    public function setEmployeVisiteur(?Employe $EmployeVisiteur): static
    {
        $this->EmployeVisiteur = $EmployeVisiteur;

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
}
