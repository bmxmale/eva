<?php

declare(strict_types=1);

namespace App\Tests\Helper;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Tools\SchemaTool;

final class DatabasePrimer
{
    private static bool $initialized = false;

    public static function createSchema(EntityManagerInterface $em): void
    {
        if (self::$initialized) {
            return;
        }

        // For sqlite file DB, ensure a fresh start
        $connection = $em->getConnection();
        $platform = $connection->getDatabasePlatform();

        $tool = new SchemaTool($em);
        $classes = $em->getMetadataFactory()->getAllMetadata();

        // Drop and recreate schema to ensure a clean state
        try {
            $tool->dropSchema($classes);
        } catch (\Throwable) {
            // ignore
        }
        if (!empty($classes)) {
            $tool->createSchema($classes);
        }

        self::$initialized = true;
    }
}
