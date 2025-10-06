<?php

declare(strict_types=1);

namespace App\Entity;

use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\GetCollection;
use App\Enum\Application\PurposeOfVisit;
use App\Enum\Application\Status;
use App\Enum\Application\VisaType;
use App\Repository\ApplicationRepository;
use App\State\Application\PassportApplicationsProvider;
use App\Trait\Entity\Column;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ApiResource(
    normalizationContext: ['groups' => ['application:read']],
    denormalizationContext: ['groups' => ['application:write']],
    operations: [
        new Post(),
        new GetCollection(
            uriTemplate: '/applications/{code}/{number}',
            requirements: [
                'code' => '[A-Z]{1,3}',
                'number' => '[A-Z0-9]+'
            ],
            // Interesting: without this, the provider is not called, but on Passport no uriVariables are defined and it works :D
            uriVariables: [
                'code' => 'code',
                'number' => 'number',
            ],
            provider: PassportApplicationsProvider::class,
        )
    ]
)]
#[ORM\Entity(repositoryClass: ApplicationRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Application
{
    use Column\Uuid;
    use Column\Timestampable;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['application:read'])]
    private ?int $id = null;


    #[Assert\NotBlank(message: "Passport must be provided.")]
    #[ORM\ManyToOne(inversedBy: 'applications', cascade: ['persist'])]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['application:read', 'application:write', 'passport:read', 'passport:write'])]
    private ?Passport $passport = null;

    #[Assert\NotBlank(message: "Visa type must be provided.")]
    #[ORM\Column(enumType: VisaType::class)]
    #[Groups(['application:read', 'application:write'])]
    private ?VisaType $visaType = null;

    #[Assert\NotBlank(message: "Purpose of visit must be provided.")]
    #[ORM\Column(enumType: PurposeOfVisit::class)]
    #[Groups(['application:read', 'application:write'])]
    private ?PurposeOfVisit $purposeOfVisit = null;

    #[Assert\NotBlank(message: "Start date must be provided.")]
    #[ApiProperty(openapiContext: ['type' => 'string', 'format' => 'date', 'example' => '2025-10-10'])]
    #[ORM\Column(type: Types::DATE_IMMUTABLE)]
    #[Groups(['application:read', 'application:write'])]
    private ?\DateTimeImmutable $startDate = null;

    #[Assert\NotBlank(message: "End date must be provided.")]
    #[Assert\GreaterThan(propertyPath: "startDate", message: "End date must be greater than start date.")]
    #[ApiProperty(openapiContext: ['type' => 'string', 'format' => 'date', 'example' => '2025-10-20'])]
    #[ORM\Column(type: Types::DATE_IMMUTABLE)]
    #[Groups(['application:read', 'application:write'])]
    private ?\DateTimeImmutable $endDate = null;

    #[ORM\Column(enumType: Status::class)]
    #[Groups(['application:read', 'application:write'])]
    private ?Status $status = Status::PENDING;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPassport(): ?Passport
    {
        return $this->passport;
    }

    public function setPassport(?Passport $passport): static
    {
        $this->passport = $passport;

        return $this;
    }

    public function getVisaType(): ?VisaType
    {
        return $this->visaType;
    }

    public function setVisaType(VisaType $visaType): static
    {
        $this->visaType = $visaType;

        return $this;
    }

    public function getPurposeOfVisit(): ?PurposeOfVisit
    {
        return $this->purposeOfVisit;
    }

    public function setPurposeOfVisit(PurposeOfVisit $purposeOfVisit): static
    {
        $this->purposeOfVisit = $purposeOfVisit;

        return $this;
    }

    public function getStartDate(): ?\DateTimeImmutable
    {
        return $this->startDate;
    }

    public function setStartDate(string|\DateTimeImmutable $startDate): static
    {
        if (is_string($startDate)) {
            $startDate = new \DateTimeImmutable($startDate);
        }

        $this->startDate = $startDate;

        return $this;
    }

    public function getEndDate(): ?\DateTimeImmutable
    {
        return $this->endDate;
    }

    public function setEndDate(string|\DateTimeImmutable $endDate): static
    {
        if (is_string($endDate)) {
            $endDate = new \DateTimeImmutable($endDate);
        }

        $this->endDate = $endDate;

        return $this;
    }

    public function getStatus(): ?Status
    {
        return $this->status;
    }

    public function setStatus(Status $status): static
    {
        $this->status = $status;

        return $this;
    }

    #[Groups(['application:read', 'passport:read'])]
    public function isValid(): bool
    {
        return (
            Status::APPROVED === $this->status
            && $this->endDate > new \DateTimeImmutable()
        );
    }
}
