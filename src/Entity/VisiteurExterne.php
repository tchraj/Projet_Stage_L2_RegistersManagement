<?php

namespace App\Entity;

use App\Repository\VisiteurExterneRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: VisiteurExterneRepository::class)]
class VisiteurExterne extends Personne
{

    #[ORM\OneToMany(mappedBy: 'visiteurExterne', targetEntity: Visite::class)]
    private Collection $visites;

    #[ORM\Column(length: 10, nullable: true)]
    private ?string $sexe = null;


    public function __construct()
    {
        $this->visites = new ArrayCollection();
    }

    /**
     * @return Collection<int, Visite>
     */
    public function getVisites(): Collection
    {
        return $this->visites;
    }

    public function addVisite(Visite $visite): static
    {
        if (!$this->visites->contains($visite)) {
            $this->visites->add($visite);
            $visite->setVisiteurExterne($this);
        }

        return $this;
    }

    public function removeVisite(Visite $visite): static
    {
        if ($this->visites->removeElement($visite)) {
            // set the owning side to null (unless already changed)
            if ($visite->getVisiteurExterne() === $this) {
                $visite->setVisiteurExterne(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->getNom() . " " . $this->getPrenoms();
    }

    public function getSexe(): ?string
    {
        return $this->sexe;
    }

    public function setSexe(?string $sexe): static
    {
        $this->sexe = $sexe;

        return $this;
    }
}
