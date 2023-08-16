<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230816072754 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE employe ADD compte_utilisateur_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE employe ADD CONSTRAINT FK_F804D3B93BE1373C FOREIGN KEY (compte_utilisateur_id) REFERENCES compte_utilisateur (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_F804D3B93BE1373C ON employe (compte_utilisateur_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE employe DROP FOREIGN KEY FK_F804D3B93BE1373C');
        $this->addSql('DROP INDEX UNIQ_F804D3B93BE1373C ON employe');
        $this->addSql('ALTER TABLE employe DROP compte_utilisateur_id');
    }
}
