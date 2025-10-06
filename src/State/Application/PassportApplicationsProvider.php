<?php

declare(strict_types=1);

namespace App\State\Application;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\Entity\Application;
use App\Enum\Passport\Code;
use App\Repository\ApplicationRepository;
use App\Repository\PassportRepository;

/**
 * Provides a collection of applications for a passport identified by {code}/{number}.
 */
final class PassportApplicationsProvider implements ProviderInterface
{
    public function __construct(
        private readonly PassportRepository $passportRepository,
        private readonly ApplicationRepository $applicationRepository,
    ) {
    }

    /**
     * @return Application[]|array|null
     */
    public function provide(Operation $operation, array $uriVariables = [], array $context = []): array|null
    {
        $code = $uriVariables['code'] ?? null;
        $number = $uriVariables['number'] ?? null;

        if (null === $code || null === $number) {
            return [];
        }

        // Validate code against enum
        if (null === Code::tryFrom((string) $code)) {
            return [];
        }

        $passport = $this->passportRepository->findByCodeNumber((string) $code, (string) $number);

        if (null === $passport) {
            return [];
        }

        return $this->applicationRepository->findByPassport($passport);
    }
}
