<?php

namespace App\Entity;

use App\Repository\RoleRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RoleRepository::class)]
class Role
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 35, nullable: true)]
    private ?string $NomRole = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description_role = null;

    // public function __construct()
    // {
    //     $this->profils = new ArrayCollection();
    // }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomRole(): ?string
    {
        return $this->NomRole;
    }

    public function setNomRole(?string $NomRole): static
    {
        $this->NomRole = $NomRole;

        return $this;
    }

    /**
     * @return Collection<int, Profil>
     */
    // public function getProfils(): Collection
    // {
    //     return $this->profils;
    // }

    // public function addProfil(Profil $profil): static
    // {
    //     if (!$this->profils->contains($profil)) {
    //         $this->profils->add($profil);
    //         $profil->addRole($this);
    //     }

    //     return $this;
    // }

    // public function removeProfil(Profil $profil): static
    // {
    //     if ($this->profils->removeElement($profil)) {
    //         $profil->removeRole($this);
    //     }

    //     return $this;
    // }
    public function __toString()
    {
        return $this->getNomRole();
    }

    public function getDescriptionRole(): ?string
    {
        return $this->description_role;
    }

    public function setDescriptionRole(?string $description_role): static
    {
        $this->description_role = $description_role;

        return $this;
    }
}
