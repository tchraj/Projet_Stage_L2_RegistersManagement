<?php

namespace App\Entity;

use App\Repository\ProfilRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProfilRepository::class)]
class Profil
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    // #[ORM\ManyToMany(targetEntity: Role::class, inversedBy: 'profils')]
    #[ORM\ManyToMany(targetEntity: Role::class)]
    private $roles;

    #[ORM\OneToMany(mappedBy: 'profil', targetEntity: CompteUtilisateur::class)]
    private Collection $comptes;

    #[ORM\Column(length: 60)]
    private ?string $nomProfil = null;

    // #[ORM\OneToMany(mappedBy: 'profil', targetEntity: CompteUtilisateur::class)]
    // private Collection $compteUtilisateurs;

    public function __construct()
    {
        $this->roles = new ArrayCollection();
        //$this->employe = new ArrayCollection();
        $this->comptes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }
    /**
     * @return Collection<int, Role>
     */
    public function getRoles(): Collection
    {
        return $this->roles;
    }

    public function addRole(Role $role): static
    {
        if (!$this->roles->contains($role)) {
            $this->roles->add($role);
        }
        return $this;
    }

    public function removeRole(Role $role): static
    {
        $this->roles->removeElement($role);

        return $this;
    }

    // /**
    //  * @return Collection<int, Employe>
    //  */
    // public function getEmploye(): Collection
    // {
    //     return $this->employe;
    // }

    // public function addEmploye(Employe $employe): static
    // {
    //     if (!$this->employe->contains($employe)) {
    //         $this->employe->add($employe);
    //         //$employe->setProfil($this);
    //     }

    //     return $this;
    // }

    // public function removeEmploye(Employe $employe): static
    // {
    //     if ($this->employe->removeElement($employe)) {
    //         // set the owning side to null (unless already changed)
    //         /* if ($employe->getProfil() === $this) {
    //             $employe->setProfil(null);
    //         } */
    //     }

    //     return $this;
    // }

    public function getNomProfil(): ?string
    {
        return $this->nomProfil;
    }

    public function setNomProfil(string $nomProfil): static
    {
        $this->nomProfil = $nomProfil;

        return $this;
    }

    /**
     * @return Collection<int, CompteUtilisateur>
     */
    public function getComptes(): Collection
    {
        return $this->comptes;
    }

    public function addComptes(CompteUtilisateur $comptes): static
    {
        if (!$this->comptes->contains($comptes)) {
            $this->comptes->add($comptes);
            $comptes->setProfil($this);
        }

        return $this;
    }

    public function removeComptes(CompteUtilisateur $compteUtilisateur): static
    {
        if ($this->comptes->removeElement($compteUtilisateur)) {
            // set the owning side to null (unless already changed)
            if ($compteUtilisateur->getProfil() === $this) {
                $compteUtilisateur->setProfil(null);
            }
        }

        return $this;
    }
    public function __toString()
    {
        return $this->getNomProfil();
    }
}
