<?php

declare(strict_types=1);

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\ApiProperty;
use App\Enum\Passport\Code;
use App\Enum\Passport\Type;
use App\Repository\PassportRepository;
use App\State\Passport\PassportItemProvider;
use App\Trait\Entity\Column;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[
    ApiResource(
        normalizationContext: [
            'groups' => ['passport:read'],
        ],
        denormalizationContext: [
            'groups' => ['passport:write'],
        ],
        operations: [
            new Post(),
            new Get(
                uriTemplate: '/passport/{code}/{number}',
                requirements: [
                    'code' => '[A-Z]{1,3}',
                    'number' => '[A-Z0-9]+'
                ],
                normalizationContext: [
                    'groups' => ['passport:read'],
                ],
                provider: PassportItemProvider::class,
            )
        ]
    )]
#[ORM\Entity(repositoryClass: PassportRepository::class)]
#[ORM\HasLifecycleCallbacks]
#[ORM\UniqueConstraint(columns: ['code', 'number'])]
#[UniqueEntity(
    fields: ['code', 'number'],
    message: 'This passport number already exists for the given country'
)]
class Passport
{
    use Column\Uuid;
    use Column\Timestampable;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Assert\Length(
        min: 3,
        max: 50,
        minMessage: 'Minimum length of passport number is {{ limit }} characters',
        maxMessage: 'Maximum length of passport number is {{ limit }} characters'
    )]
    #[Groups(['passport:read', 'passport:write', 'application:read', 'application:write'])]
    #[ORM\Column(length: 50)]
    private ?string $number = null;

    #[Groups(['passport:read', 'passport:write','application:write'])]
    #[ORM\Column(length: 3, enumType: Code::class)]
    private ?Code $code = null;

    #[Groups(['passport:read', 'passport:write', 'application:write'])]
    #[ORM\Column(length: 2, enumType: Type::class)]
    private ?Type $type = Type::ORDINARY;

    #[Groups(['passport:read', 'passport:write', 'application:write'])]
    #[ORM\Column(length: 80)]
    private ?string $firstName = null;

    #[Groups(['passport:read', 'passport:write', 'application:write'])]
    #[ORM\Column(length: 120)]
    private ?string $lastName = null;

    #[Assert\LessThanOrEqual("today", message: 'Passport must be issued in the past or today')]
    #[Groups(['passport:read', 'passport:write', 'application:write'])]
    #[ApiProperty(openapiContext: ['type' => 'string', 'format' => 'date', 'example' => '2025-01-01'])]
    #[ORM\Column(type: Types::DATE_IMMUTABLE)]
    private ?\DateTimeImmutable $issuedAt = null;

    #[Assert\GreaterThan("+6 months", message: 'Passport must be valid for at least 6 months from today')]
    #[Groups(['passport:read', 'passport:write', 'application:write'])]
    #[ApiProperty(openapiContext: ['type' => 'string', 'format' => 'date', 'example' => '2030-01-01'])]
    #[ORM\Column(type: Types::DATE_IMMUTABLE)]
    private ?\DateTimeImmutable $expiresAt = null;


    #[Groups(['application:write'])]
    #[ORM\OneToMany(targetEntity: Application::class, mappedBy: 'passport')]
    private Collection $applications;

    public function __construct()
    {
        $this->applications = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumber(): ?string
    {
        return $this->number;
    }

    public function setNumber(string $numer): static
    {
        $this->number = $numer;

        return $this;
    }

    public function getCode(): ?Code
    {
        return $this->code;
    }

    public function setCode(Code $code): static
    {
        $this->code = $code;

        return $this;
    }

    public function getType(): ?Type
    {
        return $this->type;
    }

    public function setType(Type $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): static
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): static
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getIssuedAt(): ?\DateTimeImmutable
    {
        return $this->issuedAt;
    }

    public function setIssuedAt(string|\DateTimeImmutable $issuedAt): static
    {
        if (is_string($issuedAt)) {
            $issuedAt = new \DateTimeImmutable($issuedAt);
        }

        $this->issuedAt = $issuedAt;

        return $this;
    }

    public function getExpiresAt(): ?\DateTimeImmutable
    {
        return $this->expiresAt;
    }

    public function setExpiresAt(string|\DateTimeImmutable $expiresAt): static
    {
        if (is_string($expiresAt)) {
            $expiresAt = new \DateTimeImmutable($expiresAt);
        }

        $this->expiresAt = $expiresAt;

        return $this;
    }

    public function getApplications(): Collection
    {
        return $this->applications;
    }

    public function addApplication(Application $application): static
    {
        if (!$this->applications->contains($application)) {
            $this->applications->add($application);
            $application->setPassport($this);
        }

        return $this;
    }

    public function removeApplication(Application $application): static
    {
        if ($this->applications->removeElement($application)) {
            // set the owning side to null (unless already changed)
            if ($application->getPassport() === $this) {
                $application->setPassport(null);
            }
        }

        return $this;
    }

    #[Groups('passport:read')]
    public function isValid(): bool
    {
        return $this->expiresAt > new \DateTimeImmutable();
    }
}
