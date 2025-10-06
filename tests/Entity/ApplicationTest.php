<?php

declare(strict_types=1);

namespace App\Tests\Entity;

use App\Entity\Application;
use App\Entity\Passport;
use App\Enum\Application\PurposeOfVisit;
use App\Enum\Application\Status;
use App\Enum\Application\VisaType;
use App\Enum\Passport\Code;
use App\Enum\Passport\Type as PassportType;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

final class ApplicationTest extends KernelTestCase
{
    protected static function createKernel(array $options = []): KernelInterface
    {
        return new \App\Kernel('test', true);
    }

    private function getValidator(): ValidatorInterface
    {
        self::bootKernel();
        /** @var ValidatorInterface $validator */
        $validator = static::getContainer()->get(ValidatorInterface::class);

        return $validator;
    }

    private function makePassport(): Passport
    {
        return (new Passport())
            ->setNumber('YUBICO2025')
            ->setCode(Code::UNITED_STATES)
            ->setType(PassportType::ORDINARY)
            ->setFirstName('John')
            ->setLastName('Wick')
            ->setIssuedAt(new \DateTimeImmutable('2021-06-01'))
            ->setExpiresAt((new \DateTimeImmutable('2031-06-01')));
    }

    public function testIsValidReturnsTrueWhenApprovedAndNotExpired(): void
    {
        $app = (new Application())
            ->setPassport($this->makePassport())
            ->setVisaType(VisaType::LONG_STAY)
            ->setPurposeOfVisit(PurposeOfVisit::WORK)
            ->setStartDate('2025-01-01')
            ->setEndDate('2035-12-31')
            ->setStatus(Status::APPROVED);

        self::assertTrue($app->isValid());
    }

    public function testIsValidReturnsFalseWhenPending(): void
    {
        $app = (new Application())
            ->setPassport($this->makePassport())
            ->setVisaType(VisaType::LONG_STAY)
            ->setPurposeOfVisit(PurposeOfVisit::WORK)
            ->setStartDate('2025-01-01')
            ->setEndDate('2035-12-31')
            ->setStatus(Status::PENDING);

        self::assertFalse($app->isValid());
    }

    public function testValidationFailsIfEndDateNotAfterStartDate(): void
    {
        $app = (new Application())
            ->setPassport($this->makePassport())
            ->setVisaType(VisaType::LONG_STAY)
            ->setPurposeOfVisit(PurposeOfVisit::WORK)
            ->setStartDate('2025-01-02')
            ->setEndDate('2025-01-01')
            ->setStatus(Status::APPROVED);

        $violations = $this->getValidator()->validate($app);
        self::assertGreaterThan(0, $violations->count());
        $messages = [];
        foreach ($violations as $v) {
            $messages[] = $v->getMessage();
        }
        self::assertContains('End date must be greater than start date.', $messages);
    }
}
