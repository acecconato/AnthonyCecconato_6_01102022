<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[UniqueEntity(['email'], message: 'Cette adresse email est déjà utilisée')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\Column(type: 'uuid', unique: true)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: 'doctrine.uuid_generator')]
    private ?Uuid $id = null;

    #[ORM\Column(length: 180, unique: true)]
    #[Assert\NotBlank(message: "L'adresse email ne doit pas être vide")]
    #[Assert\Email(message: "L'adresse email n'est pas valide")]
    private string $email;

    #[ORM\Column]
    #[Assert\NotBlank(message: "Le nom d'utilisateur ne doit pas être vide")]
    #[Assert\Regex(pattern: '/^[a-zA-Z0-9]+$/', message: "Le nom d'utilisateur peut contenir uniquement des chiffres et des lettres")]
    private string $username;

    /** @var array<string> */
    #[ORM\Column]
    private array $roles = [];

    #[ORM\Column]
    private string $password;

    #[Assert\NotBlank(message: 'Le mot de passe ne doit pas être vide', groups: ['password'])]
    #[Assert\NotCompromisedPassword(message: 'Le mot de passe sélectionné est présent dans une brèche de données', groups: ['password'])]
    #[Assert\Length(min: 8, max: 32, minMessage: 'Le mot de passe doit contenir au moins 8 caractères', maxMessage: 'Le mot de passe ne peut excéder 32 caractères', groups: ['password'])]
    #[Assert\Regex(pattern: '/^\S*(?=\S*[a-z])(?=\S*[\W])(?=\S*[A-Z])(?=\S*[\d])\S*$/', message: 'Format du mot de passe incorrect', groups: ['password'])]
    private ?string $plainPassword = null;

    private ?UploadedFile $avatarFile = null;

    #[ORM\Column(type: 'uuid', nullable: true)]
    private ?Uuid $registrationToken = null;

    #[ORM\Column(type: 'datetime_immutable')]
    private \DateTimeImmutable $createdAt;

    public function __construct()
    {
    }

    public function getId(): ?Uuid
    {
        return $this->id;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getUserIdentifier(): string
    {
        return $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    /**
     * @param array<string> $roles
     *
     * @return $this
     */
    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        $this->plainPassword = null;
    }

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): User
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getAvatarFile(): ?UploadedFile
    {
        return $this->avatarFile;
    }

    public function setAvatarFile(?UploadedFile $avatarFile): User
    {
        $this->avatarFile = $avatarFile;

        return $this;
    }

    public function getRegistrationToken(): ?Uuid
    {
        return $this->registrationToken;
    }

    public function setRegistrationToken(?Uuid $registrationToken): User
    {
        $this->registrationToken = $registrationToken;

        return $this;
    }

    public function hasRegistrationToken(): bool
    {
        return (bool) $this->registrationToken;
    }

    public function getPlainPassword(): ?string
    {
        return $this->plainPassword;
    }

    public function setPlainPassword(?string $plainPassword): User
    {
        $this->plainPassword = $plainPassword;

        return $this;
    }
}
