<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230729133553 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE visite CHANGE date_visite date_visite LONGTEXT NOT NULL, CHANGE heure_deb heure_deb LONGTEXT NOT NULL, CHANGE heure_fin heure_fin LONGTEXT NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE visite CHANGE date_visite date_visite DATE NOT NULL, CHANGE heure_deb heure_deb TIME NOT NULL, CHANGE heure_fin heure_fin TIME NOT NULL');
    }
}
