<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200905163529 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE glossary_entry (id INT AUTO_INCREMENT NOT NULL, term VARCHAR(160) NOT NULL, description LONGTEXT NOT NULL, relevance INT NOT NULL, creation_date DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, change_date DATETIME on update CURRENT_TIMESTAMP, UNIQUE INDEX UNIQ_40DC8026A50FE78D (term), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('DROP TABLE glossary');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE glossary (id INT AUTO_INCREMENT NOT NULL, term VARCHAR(160) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, description LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, relevance INT NOT NULL, creation_date DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, change_date DATETIME DEFAULT NULL, UNIQUE INDEX UNIQ_B0850B43A50FE78D (term), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('DROP TABLE glossary_entry');
    }
}
