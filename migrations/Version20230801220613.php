<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230801220613 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE employe CHANGE nom nom VARCHAR(30) DEFAULT NULL, CHANGE prenoms prenoms VARCHAR(60) DEFAULT NULL, CHANGE email email VARCHAR(60) DEFAULT NULL, CHANGE tel tel VARCHAR(15) DEFAULT NULL');
        $this->addSql('ALTER TABLE visiteur_externe CHANGE nom nom VARCHAR(30) DEFAULT NULL, CHANGE prenoms prenoms VARCHAR(60) DEFAULT NULL, CHANGE email email VARCHAR(60) DEFAULT NULL, CHANGE tel tel VARCHAR(15) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE employe CHANGE nom nom VARCHAR(30) NOT NULL, CHANGE prenoms prenoms VARCHAR(60) NOT NULL, CHANGE email email VARCHAR(60) NOT NULL, CHANGE tel tel VARCHAR(15) NOT NULL');
        $this->addSql('ALTER TABLE visiteur_externe CHANGE nom nom VARCHAR(30) NOT NULL, CHANGE prenoms prenoms VARCHAR(60) NOT NULL, CHANGE email email VARCHAR(60) NOT NULL, CHANGE tel tel VARCHAR(15) NOT NULL');
    }
}
