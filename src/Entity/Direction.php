<?php

namespace App\Entity;

use App\Repository\DirectionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DirectionRepository::class)]
class Direction
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $NomDirection = null;

    #[ORM\OneToMany(mappedBy: 'direction', targetEntity: Employe::class)]
    private Collection $employes;

    #[ORM\ManyToOne(inversedBy: 'directions', targetEntity: Filiale::class)]
    private ?Filiale $filiale = null;
    /* #[ORM\ManyToOne(inversedBy: 'directions', targetEntity: Filiale::class)]
    private ?string $filiale = null; */
    public function __construct()
    {
        $this->employes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomDirection(): ?string
    {
        return $this->NomDirection;
    }

    public function setNomDirection(?string $NomDirection): static
    {
        $this->NomDirection = $NomDirection;

        return $this;
    }
    /*
    /**
     * @return Collection<int, Employe>
     */
    public function getEmployes(): Collection
    {
        return $this->employes;
    }

    public function addEmploye(Employe $employe): static
    {
        if (!$this->employes->contains($employe)) {
            $this->employes->add($employe);
            $employe->setDirection($this);
        }

        return $this;
    }

    public function removeEmploye(Employe $employe): static
    {
        if ($this->employes->removeElement($employe)) {
            // set the owning side to null (unless already changed)
            if ($employe->getDirection() === $this) {
                $employe->setDirection(null);
            }
        }

        return $this;
    }

    public function getFiliale(): ?Filiale
    {
        return $this->filiale;
    }

    public function setFiliale(?Filiale $filiale): static
    {
        $this->filiale = $filiale;

        return $this;
    }
    public function __toString()
    {
        return $this->NomDirection;
    }
}
