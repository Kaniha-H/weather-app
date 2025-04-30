<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250430191051 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE weather ADD COLUMN condition VARCHAR(255) NOT NULL
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TEMPORARY TABLE __temp__weather AS SELECT id, city, temperature FROM weather
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE weather
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE weather (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, city VARCHAR(255) NOT NULL, temperature DOUBLE PRECISION NOT NULL)
        SQL);
        $this->addSql(<<<'SQL'
            INSERT INTO weather (id, city, temperature) SELECT id, city, temperature FROM __temp__weather
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE __temp__weather
        SQL);
    }
}
