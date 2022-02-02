<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[UniqueEntity(fields:'email', message: 'There is already an account with this email')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id;

    #[ORM\Column(type: 'string', length: 180, unique: true)]
    private ?string $email;

    #[ORM\Column(type: 'json')]
    private array $roles;

    #[ORM\Column(type: 'string')]
    private string $password;

    /**
     * @var string|null
     */
    private ?string $plainPassword;

    #[ORM\Column(type: 'string', length: 30)]
    private ?string $firstName;

    #[ORM\Column(type: 'string', length: 30)]
    private ?string $lastName;

    #[ORM\Column(type: 'boolean')]
    private bool $isVerified;

    #[ORM\OneToMany(mappedBy: 'assignedTo', targetEntity: TODO::class)]
    private Collection $TODOList;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private ?\DateTimeInterface $lastLoggedIn;

    public function __construct()
    {
        $this->TODOList = new ArrayCollection();
        $this->isVerified = false;
        $this->roles = [];
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
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
    public function eraseCredentials()
    {
        $this->plainPassword = null;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function isVerified(): bool
    {
        return $this->isVerified;
    }

    public function getIsVerified(): ?bool
    {
        return $this->isVerified;
    }

    public function setIsVerified(bool $isVerified): self
    {
        $this->isVerified = $isVerified;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getPlainPassword(): string|null
    {
        return $this->plainPassword;
    }

    /**
     * @param string $plainPassword
     */
    public function setPlainPassword(string $plainPassword): void
    {
        $this->plainPassword = $plainPassword;
    }

    public function getLastLoggedIn(): ?\DateTimeInterface
    {
        return $this->lastLoggedIn;
    }

    /**
     * @see UserInterface
     */
    public function setLastLoggedIn(?\DateTimeInterface $lastLoggedIn): self
    {
        $this->lastLoggedIn = $lastLoggedIn;

        return $this;
    }

    /**
     * @return Collection
     */
    public function getTODOList(): Collection
    {
        return $this->TODOList;
    }

    public function addTODOList(TODO $tODOList): self
    {
        if (!$this->TODOList->contains($tODOList)) {
            $this->TODOList[] = $tODOList;
            $tODOList->setAssignedTo($this);
        }

        return $this;
    }

    public function removeTODOList(TODO $tODOList): self
    {
        if ($this->TODOList->removeElement($tODOList)) {
            if ($tODOList->getAssignedTo() === $this) {
                $tODOList->setAssignedTo(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->email;
    }
}
