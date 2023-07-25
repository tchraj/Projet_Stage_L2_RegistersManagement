<?php

namespace App\Entity;

use App\Repository\FilialeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FilialeRepository::class)]
class Filiale
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $NomFiliale = null;

    #[ORM\OneToMany(mappedBy: 'filiale', targetEntity: Direction::class)]
    private Collection $directions;

    public function __construct()
    {
        $this->directions = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomFiliale(): ?string
    {
        return $this->NomFiliale;
    }

    public function setNomFiliale(?string $NomFiliale): static
    {
        $this->NomFiliale = $NomFiliale;

        return $this;
    }

    /**
     * @return Collection<int, Direction>
     */
    public function getDirections(): Collection
    {
        return $this->directions;
    }

    public function addDirection(Direction $direction): static
    {
        if (!$this->directions->contains($direction)) {
            $this->directions->add($direction);
            $direction->setFiliale($this);
        }

        return $this;
    }

    public function removeDirection(Direction $direction): static
    {
        if ($this->directions->removeElement($direction)) {
            // set the owning side to null (unless already changed)
            if ($direction->getFiliale() === $this) {
                $direction->setFiliale(null);
            }
        }

        return $this;
    }
    public function __toString()
    {
        return $this->NomFiliale;
    }
}
