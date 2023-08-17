<?php

namespace App\Entity;

use App\Repository\CompteUtilisateurRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: CompteUtilisateurRepository::class)]
class CompteUtilisateur implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;
    //const ROLE_ADMIN = "ROLE_ADMIN_ORGANIZATION";
    #[ORM\Column(length: 180, unique: true)]
    private ?string $username = null;

    // #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\ManyToOne(inversedBy: "comptes")]
    private ?Profil $profil;

    #[ORM\Column(length: 15, nullable: true)]
    private ?string $passClair = null;

    #[ORM\OneToOne(targetEntity: Employe::class, inversedBy: "compteUtilisateur")]
    private ?Employe $Employe;

    public function getEmploye(): ?Employe
    {
        return $this->Employe;
    }

    public function setEmploye(?Employe $employe): static
    {
        $this->Employe = $employe;

        return $this;
    }
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): static
    {
        $this->username = $username;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->username;
    }
    /**
     * @see UserInterface
     */
    // public function getRoles(): array
    // {
    //     // guarantee every user at least has ROLE_USER
    //     if ($this->getProfil() !== null) {
    //         $profil = $this->getProfil();
    //         $objRoles = $profil->getRoles();
    //         $i = 0;
    //         foreach ($objRoles as $role) {
    //             $r[$i] = $role->getNomRole();
    //             $i + 1;
    //         }
    //         $this->roles[] = $r;
    //     }
    //     //$roles[] = 'ROLE_USER';
    //     return array_unique($this->roles);
    // }
    public function getRoles(): array
    {
        // guarantee every user at least has ROLE_USER
        if ($this->getProfil() !== null) {
            $profil = $this->getProfil();
            $objRoles = $profil->getRoles();
            $r = []; // Créez un tableau pour stocker les rôles
            foreach ($objRoles as $role) {
                $r[] = $role->getNomRole(); // Ajoutez chaque rôle au tableau
            }
            $this->roles = $r; // Mettez à jour $this->roles avec le tableau de rôles
        }
        //$roles[] = 'ROLE_USER';
        return array_unique($this->roles);
    }
    public function setRoles(array $roles): static
    {
        return $this;
    }
    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterfacefsetR
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getProfil(): ?Profil
    {
        return $this->profil;
    }

    public function setProfil(?Profil $profil): static
    {
        $this->profil = $profil;

        return $this;
    }
    public function __toString()
    {
        return $this->getUsername();
    }

    public function getPassClair(): ?string
    {
        return $this->passClair;
    }

    public function setPassClair(?string $passClair): static
    {
        $this->passClair = $passClair;

        return $this;
    }
    /* public function isAdmin(): bool
    {
        return in_array(self::ROLE_ADMIN, $this->getRoles());
    } */
}
