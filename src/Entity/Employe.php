<?php

namespace App\Entity;

use App\Repository\EmployeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EmployeRepository::class)]
//#[UniqueEntity(fields: ['username'], message: 'There is already an account with this username')]
class Employe extends Personne
{
    #[ORM\ManyToOne(inversedBy: "employes")]
    private ?Direction $direction = null;

    #[ORM\OneToOne(targetEntity: CompteUtilisateur::class, mappedBy: "Employe")]
    private ?CompteUtilisateur $compteUtilisateur;

    // #[ORM\ManyToOne(targetEntity: self::class, inversedBy: 'directeur')]
    // private ?self $employe = null;

    // // #[ORM\OneToMany(mappedBy: 'employe', targetEntity: self::class)]
    // private Collection $directeur;

    #[ORM\OneToMany(mappedBy: 'EmployeVisiteur', targetEntity: Visite::class)]
    private Collection $Visiteeffectuee;

    #[ORM\OneToMany(mappedBy: 'EmployeVisite', targetEntity: Visite::class)]
    private Collection $VisiteRecue;

    #[ORM\Column(type: 'boolean')]
    private $isVerified = false;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $poste = null;

    public function __construct()
    {
        //$this->directeur = new ArrayCollection();
        $this->Visiteeffectuee = new ArrayCollection();
        $this->VisiteRecue = new ArrayCollection();
        $this->rendezVouses = new ArrayCollection();
        }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDirection(): ?Direction
    {
        return $this->direction;
    }

    public function setDirection(?Direction $direction): static
    {
        $this->direction = $direction;

        return $this;
    }

    public function getCompteUtilisateur(): ?CompteUtilisateur
    {
        return $this->compteUtilisateur;
    }

    public function setCompteUtilisateur(?CompteUtilisateur $compteUtilisateur): static
    {
        $this->compteUtilisateur = $compteUtilisateur;

        return $this;
    }

    // public function getEmploye(): ?self
    // {
    //     return $this->employe;
    // }

    // public function setEmploye(?self $employe): static
    // {
    //     $this->employe = $employe;

    //     return $this;
    // }

    /**
     * @return Collection<int, self>
     */
    // public function getDirecteur(): Collection
    // {
    //     return $this->directeur;
    // }

    // public function addDirecteur(self $directeur): static
    // {
    //     if (!$this->directeur->contains($directeur)) {
    //         $this->directeur->add($directeur);
    //         $directeur->setEmploye($this);
    //     }

    //     return $this;
    // }

    // public function removeDirecteur(self $directeur): static
    // {
    //     if ($this->directeur->removeElement($directeur)) {
    //         // set the owning side to null (unless already changed)
    //         if ($directeur->getEmploye() === $this) {
    //             $directeur->setEmploye(null);
    //         }
    //     }

    //     return $this;
    // }
    #[ORM\Column(type: 'boolean')]
    private $visible = true;

    #[ORM\OneToMany(mappedBy: 'employe', targetEntity: RendezVous::class)]
    private Collection $rendezVouses;

    public function isVisible(): bool
    {
        return $this->visible;
    }

    public function setVisible(bool $visible): self
    {
        $this->visible = $visible;

        return $this;
    }
    /**
     * @return Collection<int, Visite>
     */
    public function getVisiteeffectuee(): Collection
    {
        return $this->Visiteeffectuee;
    }

    public function addVisiteeffectuee(Visite $visiteeffectuee): static
    {
        if (!$this->Visiteeffectuee->contains($visiteeffectuee)) {
            $this->Visiteeffectuee->add($visiteeffectuee);
            $visiteeffectuee->setEmployeVisiteur($this);
        }

        return $this;
    }

    public function removeVisiteeffectuee(Visite $visiteeffectuee): static
    {
        if ($this->Visiteeffectuee->removeElement($visiteeffectuee)) {
            // set the owning side to null (unless already changed)
            if ($visiteeffectuee->getEmployeVisiteur() === $this) {
                //$visiteeffectuee->setEmployeVisiteur(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Visite>
     */
    public function getVisiteRecue(): Collection
    {
        return $this->VisiteRecue;
    }

    public function addVisiteRecue(Visite $visiteRecue): static
    {
        if (!$this->VisiteRecue->contains($visiteRecue)) {
            $this->VisiteRecue->add($visiteRecue);
            $visiteRecue->setEmployeVisite($this);
        }

        return $this;
    }

    public function removeVisiteRecue(Visite $visiteRecue): static
    {
        if ($this->VisiteRecue->removeElement($visiteRecue)) {
            // set the owning side to null (unless already changed)
            if ($visiteRecue->getEmployeVisite() === $this) {
                $visiteRecue->setEmployeVisite(null);
            }
        }

        return $this;
    }

    public function isVerified(): bool
    {
        return $this->isVerified;
    }

    public function setIsVerified(bool $isVerified): static
    {
        $this->isVerified = $isVerified;

        return $this;
    }

    public function getPoste(): ?string
    {
        return $this->poste;
    }

    public function setPoste(?string $poste): static
    {
        $this->poste = $poste;

        return $this;
    }

    public function __toString()
    {
        return $this->getNom() . " " . $this->getPrenoms();;
    }

    public function isIsVerified(): ?bool
    {
        return $this->isVerified;
    }


    public function nombreVisitesEffectuées(): int
    {
        return $this->Visiteeffectuee->count();
    }
    public function nombreVisitesRecues(): int
    {
        return $this->VisiteRecue->count();
    }

    /**
     * @return Collection<int, RendezVous>
     */
    public function getRendezVouses(): Collection
    {
        return $this->rendezVouses;
    }

    public function addRendezVouse(RendezVous $rendezVouse): static
    {
        if (!$this->rendezVouses->contains($rendezVouse)) {
            $this->rendezVouses->add($rendezVouse);
            $rendezVouse->setEmploye($this);
        }

        return $this;
    }

    public function removeRendezVouse(RendezVous $rendezVouse): static
    {
        if ($this->rendezVouses->removeElement($rendezVouse)) {
            // set the owning side to null (unless already changed)
            if ($rendezVouse->getEmploye() === $this) {
                $rendezVouse->setEmploye(null);
            }
        }

        return $this;
    }

    
}
