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

    #[ORM\Column(length: 60, nullable: true)]
    private ?string $titre = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $message = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $created_at = null;

    #[ORM\Column(nullable: true)]
    private ?bool $is_read = null;

    #[ORM\ManyToOne(inversedBy: 'notifications')]
    private ?CompteUtilisateur $sender = null;

    #[ORM\ManyToOne(inversedBy: 'notifications')]
    private ?CompteUtilisateur $recipient = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(?string $titre): static
    {
        $this->titre = $titre;

        return $this;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(?string $message): static
    {
        $this->message = $message;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeImmutable $created_at): static
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function isIsRead(): ?bool
    {
        return $this->is_read;
    }

    public function setIsRead(?bool $is_read): static
    {
        $this->is_read = $is_read;

        return $this;
    }

    public function getSender(): ?CompteUtilisateur
    {
        return $this->sender;
    }

    public function setSender(?CompteUtilisateur $sender): static
    {
        $this->sender = $sender;

        return $this;
    }

    public function getRecipient(): ?CompteUtilisateur
    {
        return $this->recipient;
    }

    public function setRecipient(?CompteUtilisateur $recipient): static
    {
        $this->recipient = $recipient;

        return $this;
    }

   
}
