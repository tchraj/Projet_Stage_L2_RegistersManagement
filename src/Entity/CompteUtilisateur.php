<?php

namespace App\Entity;

use App\Repository\CompteUtilisateurRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CompteUtilisateurRepository::class)]
class CompteUtilisateur
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 60)]
    private ?string $NomUtilisateur = null;

    #[ORM\Column(length: 15)]
    private ?string $password = null;

    #[ORM\OneToMany(mappedBy: 'compteUtilisateur', targetEntity: Employe::class)]
    private Collection $employe;

    public function __construct()
    {
        $this->employe = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomUtilisateur(): ?string
    {
        return $this->NomUtilisateur;
    }

    public function setNomUtilisateur(string $NomUtilisateur): static
    {
        $this->NomUtilisateur = $NomUtilisateur;

        return $this;
    }
    public function getPassword(): ?string
    {
        return $this->NomUtilisateur;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }


    /**
     * @return Collection<int, Employe>
     */
    public function getEmploye(): Collection
    {
        return $this->employe;
    }

    public function addEmploye(Employe $employe): static
    {
        if (!$this->employe->contains($employe)) {
            $this->employe->add($employe);
            $employe->setCompteUtilisateur($this);
        }

        return $this;
    }

    public function removeEmploye(Employe $employe): static
    {
        if ($this->employe->removeElement($employe)) {
            // set the owning side to null (unless already changed)
            if ($employe->getCompteUtilisateur() === $this) {
                $employe->setCompteUtilisateur(null);
            }
        }

        return $this;
    }
    /*
    public function __toString()
    {
        return $this->password;
    }*/
}
