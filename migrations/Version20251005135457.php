<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251005135457 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE passport (
              id INT AUTO_INCREMENT NOT NULL,
              uuid CHAR(36) NOT NULL,
              number VARCHAR(50) NOT NULL,
              code VARCHAR(3) NOT NULL,
              type VARCHAR(2) NOT NULL,
              first_name VARCHAR(80) NOT NULL,
              last_name VARCHAR(120) NOT NULL,
              issued_at DATE NOT NULL,
              expires_at DATE NOT NULL,
              created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
              updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
              UNIQUE INDEX UNIQ_B5A26E08D17F50A6 (uuid),
              UNIQUE INDEX UNIQ_B5A26E087715309896901F54 (code, number),
              PRIMARY KEY(id)
            ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE passport');
    }
}
