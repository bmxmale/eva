<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Passport;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Passport>
 */
class PassportRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Passport::class);
    }

    public function findByCodeNumber(string $code, string $number): ?Passport
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.code = :code')
            ->andWhere('p.number = :number')
            ->setParameter('code', $code)
            ->setParameter('number', $number)
            ->getQuery()
            ->getOneOrNullResult();
    }
}
