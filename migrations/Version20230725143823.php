<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230725143823 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE compte_utilisateur ADD reset_token VARCHAR(100) NOT NULL');
        $this->addSql('ALTER TABLE employe DROP filiale');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE compte_utilisateur DROP reset_token');
        $this->addSql('ALTER TABLE employe ADD filiale LONGTEXT DEFAULT NULL');
    }
}
