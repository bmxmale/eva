<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Application;
use App\Entity\Passport;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Application>
 */
class ApplicationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Application::class);
    }

    /**
     * @return Application[]
     */
    public function findByPassport(Passport $passport): array
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.passport = :passport')
            ->setParameter('passport', $passport)
            ->orderBy('a.id', 'ASC')
            ->getQuery()
            ->getResult();
    }
}
