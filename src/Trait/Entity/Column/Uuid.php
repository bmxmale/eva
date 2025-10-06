<?php

namespace App\Trait\Entity\Column;

use ApiPlatform\Metadata\ApiProperty;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\UuidInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[UniqueEntity('uuid')]
trait Uuid
{
    #[ORM\Column(type: 'uuid', unique: true)]
    private ?UuidInterface $uuid = null;

    public function getUuid(): ?UuidInterface
    {
        return $this->uuid;
    }

    #[ORM\PrePersist]
    public function initializeUuid(): void
    {
        if ($this->uuid === null) {
            $this->uuid = \Ramsey\Uuid\Uuid::uuid7();
        }
    }
}
