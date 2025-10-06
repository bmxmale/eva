<?php

declare(strict_types=1);

namespace App\Tests\Entity;

use App\Entity\Passport;
use App\Enum\Passport\Code;
use App\Enum\Passport\Type as PassportType;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

final class PassportTest extends KernelTestCase
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
            ->setExpiresAt(new \DateTimeImmutable('2031-06-01'));
    }

    public function testIsValidReturnsTrueWhenNotExpired(): void
    {
        $passport = $this->makePassport();
        self::assertTrue($passport->isValid());
    }

    public function testIsValidReturnsFalseWhenExpired(): void
    {
        $passport = $this->makePassport()->setExpiresAt((new \DateTimeImmutable('yesterday')));
        self::assertFalse($passport->isValid());
    }

    public function testValidationFailsWhenIssuedAtInFuture(): void
    {
        $tomorrow = (new \DateTimeImmutable('tomorrow'))->format('Y-m-d');
        $passport = $this->makePassport()->setIssuedAt($tomorrow);

        $violations = $this->getValidator()->validate($passport);
        self::assertGreaterThan(0, $violations->count());
        $messages = [];
        foreach ($violations as $v) {
            $messages[] = $v->getMessage();
        }
        self::assertContains('Passport must be issued in the past or today', $messages);
    }

    public function testValidationFailsWhenExpiresAtSoonerThanSixMonths(): void
    {
        $inThreeMonths = (new \DateTimeImmutable('+3 months'))->format('Y-m-d');
        $passport = $this->makePassport()->setExpiresAt($inThreeMonths);

        $violations = $this->getValidator()->validate($passport);
        self::assertGreaterThan(0, $violations->count());
        $messages = [];
        foreach ($violations as $v) {
            $messages[] = $v->getMessage();
        }
        self::assertContains('Passport must be valid for at least 6 months from today', $messages);
    }
}
