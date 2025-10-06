<?php

declare(strict_types=1);

namespace App\State\Passport;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\Entity\Passport;
use App\Enum\Passport\Code;
use App\Repository\PassportRepository;

final class PassportItemProvider implements ProviderInterface
{
    public function __construct(private readonly PassportRepository $passportRepository)
    {
    }

    public function provide(Operation $operation, array $uriVariables = [], array $context = []): ?Passport
    {
        $code = $uriVariables['code'] ?? null;
        $number = $uriVariables['number'] ?? null;

        if (null === $code || null === $number) {
            return null;
        }

        if (null === Code::tryFrom($code)) {
            return null;
        }

        return $this->passportRepository->findByCodeNumber($code, $number);
    }
}
