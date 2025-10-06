<?php

namespace App\Command\Test;

use App\Entity\Passport;
use App\Entity\Application;
use App\Enum\Passport\Code;
use App\Enum\Passport\Type;
use App\Enum\Application\PurposeOfVisit;
use App\Enum\Application\Status;
use App\Enum\Application\VisaType;
use Doctrine\ORM\EntityManagerInterface;
use Faker\Factory;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'test:generate-fixtures',
    description: 'Generates test fixtures for Passport and Application entities',
)]
class GenerateFixturesCommand extends Command
{
    public function __construct(
        private readonly EntityManagerInterface $em
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $faker = Factory::create();

        $staticPassport = new Passport();
        $staticPassport->setNumber('ABC123456');
        $staticPassport->setCode(Code::POLAND);
        $staticPassport->setType($faker->randomElement(Type::cases()));
        $staticPassport->setFirstName('Jan');
        $staticPassport->setLastName('Kowalski');
        $staticPassport->setIssuedAt(new \DateTimeImmutable('-3 years'));
        $staticPassport->setExpiresAt(new \DateTimeImmutable('+2 years'));

        $staticApp = new Application();
        $staticApp->setPassport($staticPassport);
        $staticApp->setVisaType($faker->randomElement(VisaType::cases()));
        $staticApp->setPurposeOfVisit($faker->randomElement(PurposeOfVisit::cases()));
        $staticApp->setStartDate(new \DateTimeImmutable('-1 month'));
        $staticApp->setEndDate(new \DateTimeImmutable('+1 month'));
        $staticApp->setStatus(Status::APPROVED);

        $this->em->persist($staticPassport);
        $this->em->persist($staticApp);

        foreach (range(1, 10) as $i) {
            $passport = new Passport();
            $passport->setNumber($faker->unique()->regexify('[A-Z]{3}[0-9]{6}'));

            $passport->setCode($faker->randomElement(Code::cases()));
            $passport->setType($faker->randomElement(Type::cases()));
            $passport->setFirstName($faker->firstName());
            $passport->setLastName($faker->lastName());
            $passport->setIssuedAt(
                \DateTimeImmutable::createFromMutable($faker->dateTimeBetween('-5 years', 'now'))
            );
            $passport->setExpiresAt(
                \DateTimeImmutable::createFromMutable($faker->dateTimeBetween('+6 months', '+5 years'))
            );

            // Valid visa application (endDate in the future)
            $validApp = new Application();
            $validApp->setPassport($passport);
            $validApp->setVisaType($faker->randomElement(VisaType::cases()));
            $validApp->setPurposeOfVisit($faker->randomElement(PurposeOfVisit::cases()));
            $validApp->setStartDate(
                \DateTimeImmutable::createFromMutable($faker->dateTimeBetween('-2 months', '-1 day'))
            );
            $validApp->setEndDate(
                \DateTimeImmutable::createFromMutable($faker->dateTimeBetween('+1 day', '+2 months'))
            );
            $validApp->setStatus(Status::APPROVED);

// Invalid visa application (endDate in the past)
            $invalidApp = new Application();
            $invalidApp->setPassport($passport);
            $invalidApp->setVisaType($faker->randomElement(VisaType::cases()));
            $invalidApp->setPurposeOfVisit($faker->randomElement(PurposeOfVisit::cases()));
            $invalidApp->setStartDate(
                \DateTimeImmutable::createFromMutable($faker->dateTimeBetween('-2 months', '-1 month'))
            );
            $invalidApp->setEndDate(
                \DateTimeImmutable::createFromMutable($faker->dateTimeBetween('-1 months', '-1 day'))
            );
            $invalidApp->setStatus(Status::PENDING);

            $this->em->persist($passport);
            $this->em->persist($validApp);
            $this->em->persist($invalidApp);
        }

        $this->em->flush();

        $output->writeln('Test fixtures generated successfully.');

        return Command::SUCCESS;
    }
}
