<?php

namespace App\Entity;

use App\Repository\NotificationRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: NotificationRepository::class)]
class Notification
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $dateNotif = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    private ?\DateTimeInterface $heureNotif = null;

    #[ORM\ManyToOne(inversedBy: 'notifications')]
    private ?Employe $employeNotifie = null;

    #[ORM\ManyToOne(inversedBy: 'notificationsCrees')]
    private ?Employe $emmeteur = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?Visite $visite = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $contenu = null;

    #[ORM\Column(nullable: true)]
    private ?bool $lu = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateNotif(): ?\DateTimeInterface
    {
        return $this->dateNotif;
    }

    public function setDateNotif(?\DateTimeInterface $dateNotif): static
    {
        $this->dateNotif = $dateNotif;

        return $this;
    }

    public function getHeureNotif(): ?\DateTimeInterface
    {
        return $this->heureNotif;
    }

    public function setHeureNotif(\DateTimeInterface $heureNotif): static
    {
        $this->heureNotif = $heureNotif;

        return $this;
    }

    public function getEmployeNotifie(): ?Employe
    {
        return $this->employeNotifie;
    }

    public function setEmployeNotifie(?Employe $employeNotifie): static
    {
        $this->employeNotifie = $employeNotifie;

        return $this;
    }

    public function getEmmeteur(): ?Employe
    {
        return $this->emmeteur;
    }

    public function setEmmeteur(?Employe $emmeteur): static
    {
        $this->emmeteur = $emmeteur;

        return $this;
    }

    public function getVisite(): ?Visite
    {
        return $this->visite;
    }

    public function setVisite(?Visite $visite): static
    {
        $this->visite = $visite;

        return $this;
    }

    public function getContenu(): ?string
    {
        return $this->contenu;
    }

    public function setContenu(?string $contenu): static
    {
        $this->contenu = $contenu;

        return $this;
    }

    public function isLu(): ?bool
    {
        return $this->lu;
    }

    public function setLu(?bool $lu): static
    {
        $this->lu = $lu;

        return $this;
    }
}
