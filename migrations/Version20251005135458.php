<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251005135458 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE application (
              id INT AUTO_INCREMENT NOT NULL,
              uuid CHAR(36) NOT NULL,
              passport_id INT NOT NULL,
              visa_type VARCHAR(255) NOT NULL,
              purpose_of_visit INT NOT NULL,
              start_date DATE NOT NULL,
              end_date DATE NOT NULL,
              status VARCHAR(255) NOT NULL,
              created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
              updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
              UNIQUE INDEX UNIQ_A45BDDC1D17F50A6 (uuid),
              INDEX IDX_A45BDDC1ABF410D0 (passport_id),
              PRIMARY KEY(id)
            ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE
              application
            ADD
              CONSTRAINT FK_A45BDDC1ABF410D0 FOREIGN KEY (passport_id) REFERENCES passport (id)
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE application DROP FOREIGN KEY FK_A45BDDC1ABF410D0');
        $this->addSql('DROP TABLE application');
    }
}
