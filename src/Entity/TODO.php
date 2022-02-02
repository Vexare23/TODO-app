<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\TODORepository;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation\Loggable;
use Gedmo\Mapping\Annotation\SoftDeleteable;
use Gedmo\Mapping\Annotation\Timestampable;
use Gedmo\Mapping\Annotation\Versioned;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Mapping\ClassMetadata;

#[ORM\Entity(repositoryClass: TODORepository::class)]
#[SoftDeleteable(fieldName: 'deletedAt', timeAware: false)]
#[Loggable]
class TODO
{
    use TimestampableEntity;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id;

    #[ORM\Column(type: 'string', length: 255)]
    #[Versioned]
    private ?string $name;

    #[ORM\Column(type: 'text')]
    #[Versioned]
    private ?string $description;

    #[ORM\Column(type: 'datetime')]
    #[Versioned]
    private ?\DateTimeInterface $datetime;

    #[ORM\Column(type: 'boolean')]
    #[Versioned]
    private ?bool $status;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'TODOList')]
    private ?User $assignedTo;

    #[ORM\Column(type: 'datetime', nullable: true)]
    #[Timestampable(on: 'create')]
    protected $createdAt;

    /**
     * @var \DateTime $updatedAt
     */
    #[ORM\Column(type: 'datetime', nullable: true)]
    #[Timestampable(on: 'update')]
    protected $updatedAt;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private ?\DateTimeInterface $deletedAt;

    public function __construct()
    {
        $this->status = false;
        $this->assignedTo = null;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getDatetime(): ?\DateTimeInterface
    {
        return $this->datetime;
    }

    public function setDatetime(\DateTimeInterface $datetime): self
    {
        $this->datetime = $datetime;

        return $this;
    }

    public function getStatus(): ?bool
    {
        return $this->status;
    }

    public function setStatus(bool $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getAssignedTo(): ?User
    {
        return $this->assignedTo;
    }

    public function setAssignedTo(?User $assignedTo): self
    {
        $this->assignedTo = $assignedTo;

        return $this;
    }

    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraint('datetime', new Assert\GreaterThan('+1 minutes'));
        $metadata->addPropertyConstraint('description', new Assert\NotBlank());
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(?\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getDeletedAt(): ?\DateTimeInterface
    {
        return $this->deletedAt;
    }

    public function setDeletedAt(?\DateTimeInterface $deletedAt): self
    {
        $this->deletedAt = $deletedAt;

        return $this;
    }
}
